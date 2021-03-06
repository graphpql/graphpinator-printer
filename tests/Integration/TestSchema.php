<?php

declare(strict_types = 1);

namespace Graphpinator\Printer\Tests\Integration;

final class TestSchema
{
    use \Nette\StaticClass;

    private static array $types = [];
    private static ?\Graphpinator\Container\Container $container = null;

    public static function getSchema() : \Graphpinator\Type\Schema
    {
        return new \Graphpinator\Type\Schema(
            self::getContainer(),
            self::getQuery(),
        );
    }

    public static function getFullSchema() : \Graphpinator\Type\Schema
    {
        return new \Graphpinator\Type\Schema(
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

        self::$types[$name] = match($name) {
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

    public static function getContainer() : \Graphpinator\Container\Container
    {
        if (self::$container !== null) {
            return self::$container;
        }

        self::$container = new \Graphpinator\Container\SimpleContainer([
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

    public static function getQuery() : \Graphpinator\Type\Type
    {
        return new class extends \Graphpinator\Type\Type
        {
            protected const NAME = 'Query';

            protected function getFieldDefinition() : \Graphpinator\Field\ResolvableFieldSet
            {
                return new \Graphpinator\Field\ResolvableFieldSet([
                    \Graphpinator\Field\ResolvableField::create(
                        'field1',
                        \Graphpinator\Container\Container::String(),
                        static function () : void {},
                    ),
                    \Graphpinator\Field\ResolvableField::create(
                        'fieldWithDescription',
                        \Graphpinator\Container\Container::String(),
                        static function () : void {},
                    )->setDescription('Description to field'),
                    \Graphpinator\Field\ResolvableField::create(
                        'field2',
                        \Graphpinator\Container\Container::String(),
                        static function () : void {},
                    ),
                ]);
            }

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }
        };
    }

    public static function getSimpleType() : \Graphpinator\Type\Type
    {
        return new class extends \Graphpinator\Type\Type
        {
            protected const NAME = 'SimpleType';
            protected const DESCRIPTION = 'Description for SimpleType';

            protected function getFieldDefinition() : \Graphpinator\Field\ResolvableFieldSet
            {
                return new \Graphpinator\Field\ResolvableFieldSet([
                    new \Graphpinator\Field\ResolvableField(
                        'name',
                        \Graphpinator\Container\Container::String()->notNull(),
                        static function (\stdClass $parent) {
                        },
                    ),
                ]);
            }

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }
        };
    }

    public static function getSimpleUnion() : \Graphpinator\Type\UnionType
    {
        return new class extends \Graphpinator\Type\UnionType
        {
            protected const NAME = 'SimpleUnion';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Type\ConcreteSet([
                    TestSchema::getSimpleType(),
                    TestSchema::getChildType(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }
        };
    }

    public static function getSimpleInput() : \Graphpinator\Type\InputType
    {
        return new class extends \Graphpinator\Type\InputType
        {
            protected const NAME = 'SimpleInput';

            protected function getFieldDefinition() : \Graphpinator\Argument\ArgumentSet
            {
                return new \Graphpinator\Argument\ArgumentSet([
                    new \Graphpinator\Argument\Argument(
                        'name',
                        \Graphpinator\Container\Container::String()->notNull(),
                    ),
                    new \Graphpinator\Argument\Argument(
                        'number',
                        \Graphpinator\Container\Container::Int()->notNullList(),
                    ),
                    new \Graphpinator\Argument\Argument(
                        'bool',
                        \Graphpinator\Container\Container::Boolean(),
                    ),
                ]);
            }
        };
    }

    public static function getComplexDefaultsInput() : \Graphpinator\Type\InputType
    {
        return new class extends \Graphpinator\Type\InputType {
            protected const NAME = 'ComplexDefaultsInput';
            protected const DESCRIPTION =  'ComplexDefaultsInput description';

            protected function getFieldDefinition(): \Graphpinator\Argument\ArgumentSet
            {
                return new \Graphpinator\Argument\ArgumentSet([
                    \Graphpinator\Argument\Argument::create(
                        'name',
                        \Graphpinator\Container\Container::String(),
                    )->setDefaultValue('default'),
                    \Graphpinator\Argument\Argument::create(
                        'inner',
                        $this,
                    ),
                    \Graphpinator\Argument\Argument::create(
                        'innerList',
                        $this->list(),
                    ),
                ]);
            }

            protected function afterGetFieldDefinition(): void
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

    public static function getSimpleEnum() : \Graphpinator\Type\EnumType
    {
        return new class extends \Graphpinator\Type\EnumType
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

    public static function getArrayEnum() : \Graphpinator\Type\EnumType
    {
        return new class extends \Graphpinator\Type\EnumType
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

    public static function getDescriptionEnum() : \Graphpinator\Type\EnumType
    {
        return new class extends \Graphpinator\Type\EnumType
        {
            protected const NAME = 'DescriptionEnum';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\EnumItem\EnumItemSet([
                    new \Graphpinator\EnumItem\EnumItem('A', 'single line description'),
                    (new \Graphpinator\EnumItem\EnumItem('B'))
                        ->setDeprecated(),
                    new \Graphpinator\EnumItem\EnumItem('C', 'multi line' . \PHP_EOL . 'description'),
                    (new \Graphpinator\EnumItem\EnumItem('D', 'single line description'))
                        ->setDeprecated('reason'),
                ]));
            }
        };
    }

    public static function getSimpleScalar() : \Graphpinator\Type\ScalarType
    {
        return new class extends \Graphpinator\Type\ScalarType
        {
            protected const NAME = 'SimpleScalar';

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }
        };
    }

    public static function getParentInterface() : \Graphpinator\Type\InterfaceType
    {
        return new class extends \Graphpinator\Type\InterfaceType
        {
            protected const NAME = 'ParentInterface';
            protected const DESCRIPTION = 'ParentInterface Description';

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue {}

            protected function getFieldDefinition() : \Graphpinator\Field\FieldSet
            {
                return new \Graphpinator\Field\FieldSet([
                    new \Graphpinator\Field\Field('name', \Graphpinator\Container\Container::String()->notNull()),
                ]);
            }
        };
    }

    public static function getChildInterface() : \Graphpinator\Type\InterfaceType
    {
        return new class extends \Graphpinator\Type\InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Type\InterfaceSet([
                    TestSchema::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue {}

            protected function getFieldDefinition() : \Graphpinator\Field\FieldSet
            {
                return new \Graphpinator\Field\FieldSet([
                    new \Graphpinator\Field\Field('number', \Graphpinator\Container\Container::Int()->notNull()),
                ]);
            }
        };
    }

    public static function getSecondInterface() : \Graphpinator\Type\InterfaceType
    {
        return new class extends \Graphpinator\Type\InterfaceType
        {
            protected const NAME = 'SecondInterface';

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue {}

            protected function getFieldDefinition() : \Graphpinator\Field\FieldSet
            {
                return new \Graphpinator\Field\FieldSet([
                    new \Graphpinator\Field\Field(
                        'secondField',
                        \Graphpinator\Container\Container::String()->notNull(),
                    ),
                ]);
            }
        };
    }

    public static function getChildType() : \Graphpinator\Type\Type
    {
        return new class extends \Graphpinator\Type\Type
        {
            protected const NAME = 'ChildType';
            protected const DESCRIPTION = null;

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Type\InterfaceSet([
                    TestSchema::getChildInterface(),
                    TestSchema::getSecondInterface(),
                ]));
            }

            protected function getFieldDefinition() : \Graphpinator\Field\ResolvableFieldSet
            {
                return new \Graphpinator\Field\ResolvableFieldSet([
                    \Graphpinator\Field\ResolvableField::create(
                        'name',
                        \Graphpinator\Container\Container::String()->notNull(),
                        static function (\stdClass $parent, string $argName) {},
                    ),
                    \Graphpinator\Field\ResolvableField::create(
                        'number',
                        \Graphpinator\Container\Container::Int()->notNull(),
                        static function (\stdClass $parent, string $argName) {},
                    ),
                    \Graphpinator\Field\ResolvableField::create(
                        'secondField',
                        \Graphpinator\Container\Container::String()->notNull(),
                        static function (\stdClass $parent, string $argName) {},
                    ),
                ]);
            }

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }
        };
    }

    public static function getSimpleDirective() : \Graphpinator\Directive\Directive
    {
        return new class extends \Graphpinator\Directive\Directive implements \Graphpinator\Directive\Contract\FieldLocation
        {
            protected const NAME = 'simpleDirective';
            protected const REPEATABLE = true;

            protected function getFieldDefinition(): \Graphpinator\Argument\ArgumentSet
            {
                return new \Graphpinator\Argument\ArgumentSet([
                    \Graphpinator\Argument\Argument::create('reason', \Graphpinator\Container\Container::String()),
                ]);
            }

            public function resolveFieldBefore(\Graphpinator\Value\ArgumentValueSet $arguments) : string
            {
            }

            public function resolveFieldAfter(\Graphpinator\Value\ArgumentValueSet $arguments, \Graphpinator\Value\FieldValue $fieldValue) : string
            {
            }

            public function validateFieldUsage(\Graphpinator\Field\Field $field, \Graphpinator\Value\ArgumentValueSet $arguments,): bool
            {
                return true;
            }
        };
    }
}
