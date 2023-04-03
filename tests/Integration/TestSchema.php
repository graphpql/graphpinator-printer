<?php

declare(strict_types = 1);

namespace Graphpinator\Printer\Tests\Integration;

final class TestSchema
{
    use \Nette\StaticClass;

    private static array $types = [];
    private static ?\Graphpinator\Typesystem\Container $container = null;

    public static function getSchema() : \Graphpinator\Typesystem\Schema
    {
        return new \Graphpinator\Typesystem\Schema(
            self::getContainer(),
            self::getQuery(),
        );
    }

    public static function getFullSchema() : \Graphpinator\Typesystem\Schema
    {
        return new \Graphpinator\Typesystem\Schema(
            self::getContainer(),
            self::getQuery(),
            self::getQuery(),
            self::getQuery(),
        );
    }

    public static function getType(string $name) : object
    {
        if (\array_key_exists($name, self::$types)) {
            return self::$types[$name];
        }

        self::$types[$name] = match ($name) {
            'Query' => self::getQuery(),
            'SimpleType' => self::getSimpleType(),
            'SimpleUnion' => self::getSimpleUnion(),
            'SimpleInput' => self::getSimpleInput(),
            'ComplexDefaultsInput' => self::getComplexDefaultsInput(),
            'SimpleEnum' => self::getSimpleEnum(),
            'DescriptionEnum' => self::getDescriptionEnum(),
            'SimpleScalar' => self::getSimpleScalar(),
            'ParentInterface' => self::getParentInterface(),
            'ChildInterface' => self::getChildInterface(),
            'SecondInterface' => self::getSecondInterface(),
            'ChildType' => self::getChildType(),
            'simpleDirective' => self::getSimpleDirective(),
        };

        return self::$types[$name];
    }

    public static function getContainer() : \Graphpinator\Typesystem\Container
    {
        if (self::$container !== null) {
            return self::$container;
        }

        self::$container = new \Graphpinator\SimpleContainer([
            'Query' => self::getQuery(),
            'SimpleType' => self::getSimpleType(),
            'SimpleUnion' => self::getSimpleUnion(),
            'SimpleInput' => self::getSimpleInput(),
            'ComplexDefaultsInput' => self::getComplexDefaultsInput(),
            'SimpleEnum' => self::getSimpleEnum(),
            'DescriptionEnum' => self::getDescriptionEnum(),
            'SimpleScalar' => self::getSimpleScalar(),
            'ParentInterface' => self::getParentInterface(),
            'ChildInterface' => self::getChildInterface(),
            'SecondInterface' => self::getSecondInterface(),
            'ChildType' => self::getChildType(),
        ], [
            'simpleDirective' => self::getSimpleDirective(),
        ]);

        return self::$container;
    }

    public static function getQuery() : \Graphpinator\Typesystem\Type
    {
        return new class extends \Graphpinator\Typesystem\Type
        {
            protected const NAME = 'Query';

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\ResolvableFieldSet
            {
                return new \Graphpinator\Typesystem\Field\ResolvableFieldSet([
                    \Graphpinator\Typesystem\Field\ResolvableField::create(
                        'field1',
                        \Graphpinator\Typesystem\Container::String(),
                        static function () : void {
                        },
                    ),
                    \Graphpinator\Typesystem\Field\ResolvableField::create(
                        'fieldWithDescription',
                        \Graphpinator\Typesystem\Container::String(),
                        static function () : void {
                        },
                    )->setDescription('Description to field'),
                    \Graphpinator\Typesystem\Field\ResolvableField::create(
                        'field2',
                        \Graphpinator\Typesystem\Container::String(),
                        static function () : void {
                        },
                    ),
                ]);
            }
        };
    }

    public static function getSimpleType() : \Graphpinator\Typesystem\Type
    {
        return new class extends \Graphpinator\Typesystem\Type
        {
            protected const NAME = 'SimpleType';
            protected const DESCRIPTION = 'Description for SimpleType';

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\ResolvableFieldSet
            {
                return new \Graphpinator\Typesystem\Field\ResolvableFieldSet([
                    new \Graphpinator\Typesystem\Field\ResolvableField(
                        'name',
                        \Graphpinator\Typesystem\Container::String()->notNull(),
                        static function (\stdClass $parent) : void {
                        },
                    ),
                ]);
            }
        };
    }

    public static function getSimpleUnion() : \Graphpinator\Typesystem\UnionType
    {
        return new class extends \Graphpinator\Typesystem\UnionType
        {
            protected const NAME = 'SimpleUnion';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\TypeSet([
                    TestSchema::getSimpleType(),
                    TestSchema::getChildType(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }
        };
    }

    public static function getSimpleInput() : \Graphpinator\Typesystem\InputType
    {
        return new class extends \Graphpinator\Typesystem\InputType
        {
            protected const NAME = 'SimpleInput';

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Argument\ArgumentSet
            {
                return new \Graphpinator\Typesystem\Argument\ArgumentSet([
                    new \Graphpinator\Typesystem\Argument\Argument(
                        'name',
                        \Graphpinator\Typesystem\Container::String()->notNull(),
                    ),
                    new \Graphpinator\Typesystem\Argument\Argument(
                        'number',
                        \Graphpinator\Typesystem\Container::Int()->notNullList(),
                    ),
                    new \Graphpinator\Typesystem\Argument\Argument(
                        'bool',
                        \Graphpinator\Typesystem\Container::Boolean(),
                    ),
                ]);
            }
        };
    }

    public static function getComplexDefaultsInput() : \Graphpinator\Typesystem\InputType
    {
        return new class extends \Graphpinator\Typesystem\InputType {
            protected const NAME = 'ComplexDefaultsInput';
            protected const DESCRIPTION = 'ComplexDefaultsInput description';

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Argument\ArgumentSet
            {
                return new \Graphpinator\Typesystem\Argument\ArgumentSet([
                    \Graphpinator\Typesystem\Argument\Argument::create(
                        'name',
                        \Graphpinator\Typesystem\Container::String(),
                    )->setDefaultValue('default'),
                    \Graphpinator\Typesystem\Argument\Argument::create(
                        'inner',
                        $this,
                    ),
                    \Graphpinator\Typesystem\Argument\Argument::create(
                        'innerList',
                        $this->list(),
                    ),
                ]);
            }

            protected function afterGetFieldDefinition() : void
            {
                $this->arguments['inner']->setDefaultValue((object) [
                    'name' => 'innerDefault',
                    'inner' => (object) ['name' => 'innerInnerDefault', 'inner' => null, 'innerList' => []],
                    'innerList' => null,
                ]);
                $this->arguments['innerList']->setDefaultValue([
                    (object) [
                        'name' => 'innerList1',
                        'inner' => null,
                        'innerList' => [
                            (object) ['name' => 'string', 'inner' => null, 'innerList' => null],
                            (object) ['name' => 'string', 'inner' => null, 'innerList' => null],
                        ],
                    ],
                    (object) [
                        'name' => 'innerList2',
                        'inner' => null,
                        'innerList' => [
                            (object) ['name' => 'string2', 'inner' => null, 'innerList' => null],
                            (object) ['name' => 'string2', 'inner' => null, 'innerList' => null],
                        ],
                    ],
                ]);
            }
        };
    }

    public static function getSimpleEnum() : \Graphpinator\Typesystem\EnumType
    {
        return new class extends \Graphpinator\Typesystem\EnumType
        {
            public const A = 'A';
            public const B = 'B';
            public const C = 'C';
            public const D = 'D';

            protected const NAME = 'SimpleEnum';

            public function __construct()
            {
                parent::__construct(self::fromConstants());
            }
        };
    }

    public static function getArrayEnum() : \Graphpinator\Typesystem\EnumType
    {
        return new class extends \Graphpinator\Typesystem\EnumType
        {
            /** First description */
            public const A = 'A';
            /** Second description */
            public const B = 'B';
            /** Third description */
            public const C = 'C';

            protected const NAME = 'ArrayEnum';

            public function __construct()
            {
                parent::__construct(self::fromConstants());
            }
        };
    }

    public static function getDescriptionEnum() : \Graphpinator\Typesystem\EnumType
    {
        return new class extends \Graphpinator\Typesystem\EnumType
        {
            protected const NAME = 'DescriptionEnum';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\EnumItem\EnumItemSet([
                    new \Graphpinator\Typesystem\EnumItem\EnumItem('A', 'single line description'),
                    (new \Graphpinator\Typesystem\EnumItem\EnumItem('B'))
                        ->setDeprecated(),
                    new \Graphpinator\Typesystem\EnumItem\EnumItem('C', 'multi line' . \PHP_EOL . 'description'),
                    (new \Graphpinator\Typesystem\EnumItem\EnumItem('D', 'single line description'))
                        ->setDeprecated('reason'),
                ]));
            }
        };
    }

    public static function getSimpleScalar() : \Graphpinator\Typesystem\ScalarType
    {
        return new class extends \Graphpinator\Typesystem\ScalarType
        {
            protected const NAME = 'SimpleScalar';

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }
        };
    }

    public static function getParentInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ParentInterface';
            protected const DESCRIPTION = 'ParentInterface Description';

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    new \Graphpinator\Typesystem\Field\Field('name', \Graphpinator\Typesystem\Container::String()->notNull()),
                ]);
            }
        };
    }

    public static function getChildInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\InterfaceSet([
                    TestSchema::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    new \Graphpinator\Typesystem\Field\Field('number', \Graphpinator\Typesystem\Container::Int()->notNull()),
                ]);
            }
        };
    }

    public static function getSecondInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'SecondInterface';

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    new \Graphpinator\Typesystem\Field\Field(
                        'secondField',
                        \Graphpinator\Typesystem\Container::String()->notNull(),
                    ),
                ]);
            }
        };
    }

    public static function getChildType() : \Graphpinator\Typesystem\Type
    {
        return new class extends \Graphpinator\Typesystem\Type
        {
            protected const NAME = 'ChildType';
            protected const DESCRIPTION = null;

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\InterfaceSet([
                    TestSchema::getChildInterface(),
                    TestSchema::getSecondInterface(),
                ]));
            }

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\ResolvableFieldSet
            {
                return new \Graphpinator\Typesystem\Field\ResolvableFieldSet([
                    \Graphpinator\Typesystem\Field\ResolvableField::create(
                        'name',
                        \Graphpinator\Typesystem\Container::String()->notNull(),
                        static function (\stdClass $parent, string $argName) : void {
                        },
                    ),
                    \Graphpinator\Typesystem\Field\ResolvableField::create(
                        'number',
                        \Graphpinator\Typesystem\Container::Int()->notNull(),
                        static function (\stdClass $parent, string $argName) : void {
                        },
                    ),
                    \Graphpinator\Typesystem\Field\ResolvableField::create(
                        'secondField',
                        \Graphpinator\Typesystem\Container::String()->notNull(),
                        static function (\stdClass $parent, string $argName) : void {
                        },
                    ),
                ]);
            }
        };
    }

    public static function getSimpleDirective() : \Graphpinator\Typesystem\Directive
    {
        return new class extends \Graphpinator\Typesystem\Directive implements \Graphpinator\Typesystem\Location\FieldLocation
        {
            protected const NAME = 'simpleDirective';
            protected const REPEATABLE = true;

            public function resolveFieldBefore(\Graphpinator\Value\ArgumentValueSet $arguments) : \Graphpinator\Typesystem\Location\SelectionDirectiveResult
            {
            }

            public function resolveFieldAfter(\Graphpinator\Value\ArgumentValueSet $arguments, \Graphpinator\Value\FieldValue $fieldValue) : \Graphpinator\Typesystem\Location\SelectionDirectiveResult
            {
            }

            public function validateFieldUsage(\Graphpinator\Typesystem\Field\Field $field, \Graphpinator\Value\ArgumentValueSet $arguments) : bool
            {
                return true;
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Argument\ArgumentSet
            {
                return new \Graphpinator\Typesystem\Argument\ArgumentSet([
                    \Graphpinator\Typesystem\Argument\Argument::create('reason', \Graphpinator\Typesystem\Container::String()),
                ]);
            }
        };
    }
}
