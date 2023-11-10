<?php

declare(strict_types = 1);

namespace Graphpinator\Printer\Tests\Integration;

final class PrintTest extends \PHPUnit\Framework\TestCase
{
    public static function simpleDataProvider() : array
    {
        $container = new \Graphpinator\SimpleContainer([], []);

        return [
            [
                \Graphpinator\Typesystem\Container::Int(),
                <<<'EOL'
                """
                Int built-in type (32 bit)
                """
                scalar Int
                EOL,
            ],
            [
                new \Graphpinator\Introspection\TypeKind(),
                <<<'EOL'
                """
                Built-in introspection type
                """
                enum __TypeKind {
                  SCALAR
                  OBJECT
                  INTERFACE
                  UNION
                  ENUM
                  INPUT_OBJECT
                  LIST
                  NON_NULL
                }
                EOL,
            ],
            [
                new \Graphpinator\Introspection\Schema($container),
                <<<'EOL'
                """
                Built-in introspection type
                """
                type __Schema {
                  description: String
                  types: [__Type!]!
                  queryType: __Type!
                  mutationType: __Type
                  subscriptionType: __Type
                  directives: [__Directive!]!
                }
                EOL,
            ],
            [
                new \Graphpinator\Introspection\Type($container),
                <<<'EOL'
                """
                Built-in introspection type
                """
                type __Type {
                  kind: __TypeKind!
                  name: String
                  description: String
                  fields(
                    includeDeprecated: Boolean! = false
                  ): [__Field!]
                  interfaces: [__Type!]
                  possibleTypes: [__Type!]
                  enumValues(
                    includeDeprecated: Boolean! = false
                  ): [__EnumValue!]
                  inputFields(
                    includeDeprecated: Boolean! = false
                  ): [__InputValue!]
                  ofType: __Type
                  specifiedByURL: String
                  isOneOf: Boolean
                }
                EOL,
            ],
            [
                new \Graphpinator\Introspection\Directive($container),
                <<<'EOL'
                """
                Built-in introspection type
                """
                type __Directive {
                  name: String!
                  description: String
                  locations: [__DirectiveLocation!]!
                  args: [__InputValue!]!
                  isRepeatable: Boolean!
                }
                EOL,
            ],
            [
                TestSchema::getSchema(),
                <<<'EOL'
                schema {
                  query: Query
                }
                EOL,
            ],
            [
                TestSchema::getFullSchema()->setDescription('Schema description'),
                <<<'EOL'
                """
                Schema description
                """
                schema {
                  query: Query
                  mutation: Query
                  subscription: Query
                }
                EOL,
            ],
        ];
    }

    /**
     * @dataProvider simpleDataProvider
     * @param \Graphpinator\Typesystem\Contract\Entity $type
     * @param string $print
     */
    public function testSimple(\Graphpinator\Typesystem\Contract\Entity $type, string $print) : void
    {
        $visitor = new \Graphpinator\Printer\TextVisitor();
        self::assertSame($print, $type->accept($visitor));
    }

    public function testPrintSchema() : void
    {
        $expected = <<<'EOL'
        schema {
          query: Query
        }
        
        interface ChildInterface implements ParentInterface {
          name: String!
          number: Int!
        }
        
        type ChildType implements ParentInterface & ChildInterface & SecondInterface {
          name: String!
          number: Int!
          secondField: String!
        }
        
        """
        ComplexDefaultsInput description
        """
        input ComplexDefaultsInput {
          name: String = "default"
          inner: ComplexDefaultsInput = {
            name: "innerDefault",
            inner: {
              name: "innerInnerDefault",
              inner: null,
              innerList: []
            }
          }
          innerList: [ComplexDefaultsInput] = [
            {
              name: "innerList1",
              inner: null,
              innerList: [
                {
                  name: "string",
                  inner: null,
                  innerList: null
                },
                {
                  name: "string",
                  inner: null,
                  innerList: null
                }
              ]
            },
            {
              name: "innerList2",
              inner: null,
              innerList: [
                {
                  name: "string2",
                  inner: null,
                  innerList: null
                },
                {
                  name: "string2",
                  inner: null,
                  innerList: null
                }
              ]
            }
          ]
        }
        
        enum DescriptionEnum {
          "single line description"
          A
        
          B @deprecated
        
          """
          multi line
          description
          """
          C
        
          "single line description"
          D @deprecated(reason: "reason")
        }
        
        """
        ParentInterface Description
        """
        interface ParentInterface {
          name: String!
        }
        
        type Query {
          field1: String
        
          "Description to field"
          fieldWithDescription: String
        
          field2: String
        }
        
        interface SecondInterface {
          secondField: String!
        }
        
        enum SimpleEnum {
          A
          B
          C
          D
        }
        
        input SimpleInput {
          name: String!
          number: [Int!]!
          bool: Boolean
        }
        
        scalar SimpleScalar
        
        """
        Description for SimpleType
        """
        type SimpleType {
          name: String!
        }
        
        union SimpleUnion = SimpleType | ChildType
        
        directive @simpleDirective(
          reason: String
        ) repeatable on FIELD
        EOL;

        $printer = new \Graphpinator\Printer\Printer(
            new \Graphpinator\Printer\TextVisitor(),
        );

        self::assertSame($expected, $printer->printSchema(TestSchema::getSchema()));
    }

    public function testValidateCorrectOrder() : void
    {
        $expected = [
            'interface ChildInterface',
            'interface ParentInterface',
            'interface SecondInterface',
            'type ChildType',
            'type SimpleType',
            'union SimpleUnion',
            'input ComplexDefaultsInput',
            'input SimpleInput',
            'enum DescriptionEnum',
            'enum SimpleEnum',
            'directive @simpleDirective',
        ];

        $printer = new \Graphpinator\Printer\Printer(
            new \Graphpinator\Printer\TextVisitor(),
            new \Graphpinator\Printer\TypeKindSorter(),
        );
        $schema = $printer->printSchema(TestSchema::getSchema());
        $lastCheckedPos = 0;

        foreach ($expected as $type) {
            $pos = \strpos($schema, $type);
            self::assertGreaterThan($lastCheckedPos, $pos);
            $lastCheckedPos = $pos;
        }
    }
}
