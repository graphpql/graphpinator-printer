<?php

declare(strict_types = 1);

namespace Graphpinator\Printer\Tests\Integration;

use Graphpinator\Typesystem\Introspection\Directive;
use Graphpinator\Typesystem\Introspection\Schema;
use Graphpinator\Typesystem\Introspection\Type;
use Graphpinator\Typesystem\Introspection\TypeKind;
use Graphpinator\Printer\Printer;
use Graphpinator\Printer\TextVisitor;
use Graphpinator\Printer\TypeKindSorter;
use Graphpinator\SimpleContainer;
use Graphpinator\Typesystem\Container;
use Graphpinator\Typesystem\Contract\Entity;
use PHPUnit\Framework\TestCase;

final class PrintTest extends TestCase
{
    public static function simpleDataProvider() : array
    {
        $container = new SimpleContainer([], []);

        return [
            [
                Container::Int(),
                <<<'EOL'
                """
                Int built-in type (32 bit)
                """
                scalar Int
                EOL,
            ],
            [
                new TypeKind(),
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
                new Schema($container),
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
                new Type($container),
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
                new Directive($container),
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
     * @param Entity $type
     * @param string $print
     */
    public function testSimple(Entity $type, string $print) : void
    {
        $visitor = new TextVisitor();
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

        type SimpleType {
          name: String!
        }
        
        union SimpleUnion = SimpleType | ChildType
        
        directive @simpleDirective(
          reason: String
        ) repeatable on FIELD
        EOL;

        $printer = new Printer(
            new TextVisitor(),
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

        $printer = new Printer(
            new TextVisitor(),
            new TypeKindSorter(),
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
