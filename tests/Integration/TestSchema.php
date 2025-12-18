<?php

declare(strict_types = 1);

namespace Graphpinator\Printer\Tests\Integration;

use Graphpinator\SimpleContainer;
use Graphpinator\Typesystem\Argument\Argument;
use Graphpinator\Typesystem\Argument\ArgumentSet;
use Graphpinator\Typesystem\Container;
use Graphpinator\Typesystem\Directive;
use Graphpinator\Typesystem\EnumItem\EnumItem;
use Graphpinator\Typesystem\EnumItem\EnumItemSet;
use Graphpinator\Typesystem\EnumType;
use Graphpinator\Typesystem\Field\Field;
use Graphpinator\Typesystem\Field\FieldSet;
use Graphpinator\Typesystem\Field\ResolvableField;
use Graphpinator\Typesystem\Field\ResolvableFieldSet;
use Graphpinator\Typesystem\InputType;
use Graphpinator\Typesystem\InterfaceSet;
use Graphpinator\Typesystem\InterfaceType;
use Graphpinator\Typesystem\Location\FieldLocation;
use Graphpinator\Typesystem\Location\SelectionDirectiveResult;
use Graphpinator\Typesystem\ScalarType;
use Graphpinator\Typesystem\Schema;
use Graphpinator\Typesystem\Type;
use Graphpinator\Typesystem\TypeSet;
use Graphpinator\Typesystem\UnionType;
use Graphpinator\Value\ArgumentValueSet;
use Graphpinator\Value\FieldValue;
use Graphpinator\Value\TypeIntermediateValue;

final class TestSchema
{
    private static array $types = [];
    private static ?Container $container = null;

    public static function getSchema() : Schema
    {
        return new Schema(
            self::getContainer(),
            self::getQuery(),
        );
    }

    public static function getFullSchema() : Schema
    {
        return new Schema(
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

    public static function getContainer() : Container
    {
        if (self::$container !== null) {
            return self::$container;
        }

        self::$container = new SimpleContainer([
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

    public static function getQuery() : Type
    {
        return new class extends Type
        {
            protected const NAME = 'Query';

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }

            protected function getFieldDefinition() : ResolvableFieldSet
            {
                return new ResolvableFieldSet([
                    ResolvableField::create(
                        'field1',
                        Container::String(),
                        static function () : void {
                        },
                    ),
                    ResolvableField::create(
                        'fieldWithDescription',
                        Container::String(),
                        static function () : void {
                        },
                    )->setDescription('Description to field'),
                    ResolvableField::create(
                        'field2',
                        Container::String(),
                        static function () : void {
                        },
                    ),
                ]);
            }
        };
    }

    public static function getSimpleType() : Type
    {
        return new class extends Type
        {
            protected const NAME = 'SimpleType';

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }

            protected function getFieldDefinition() : ResolvableFieldSet
            {
                return new ResolvableFieldSet([
                    new ResolvableField(
                        'name',
                        Container::String()->notNull(),
                        static function (\stdClass $parent) : void {
                        },
                    ),
                ]);
            }
        };
    }

    public static function getSimpleUnion() : UnionType
    {
        return new class extends UnionType
        {
            protected const NAME = 'SimpleUnion';

            public function __construct()
            {
                parent::__construct(new TypeSet([
                    TestSchema::getSimpleType(),
                    TestSchema::getChildType(),
                ]));
            }

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }
        };
    }

    public static function getSimpleInput() : InputType
    {
        return new class extends InputType
        {
            protected const NAME = 'SimpleInput';

            protected function getFieldDefinition() : ArgumentSet
            {
                return new ArgumentSet([
                    new Argument(
                        'name',
                        Container::String()->notNull(),
                    ),
                    new Argument(
                        'number',
                        Container::Int()->notNullList(),
                    ),
                    new Argument(
                        'bool',
                        Container::Boolean(),
                    ),
                ]);
            }
        };
    }

    public static function getComplexDefaultsInput() : InputType
    {
        return new class extends InputType {
            protected const NAME = 'ComplexDefaultsInput';

            protected function getFieldDefinition() : ArgumentSet
            {
                return new ArgumentSet([
                    Argument::create(
                        'name',
                        Container::String(),
                    )->setDefaultValue('default'),
                    Argument::create(
                        'inner',
                        $this,
                    ),
                    Argument::create(
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

    public static function getSimpleEnum() : EnumType
    {
        return new class extends EnumType
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

    public static function getArrayEnum() : EnumType
    {
        return new class extends EnumType
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

    public static function getDescriptionEnum() : EnumType
    {
        return new class extends EnumType
        {
            protected const NAME = 'DescriptionEnum';

            public function __construct()
            {
                parent::__construct(new EnumItemSet([
                    new EnumItem('A', 'single line description'),
                    (new EnumItem('B'))
                        ->setDeprecated(),
                    new EnumItem('C', 'multi line' . \PHP_EOL . 'description'),
                    (new EnumItem('D', 'single line description'))
                        ->setDeprecated('reason'),
                ]));
            }
        };
    }

    public static function getSimpleScalar() : ScalarType
    {
        return new class extends ScalarType
        {
            protected const NAME = 'SimpleScalar';

            public function validateAndCoerceInput($rawValue) : bool
            {
                return true;
            }

            public function coerceOutput(mixed $rawValue) : string|int|float|bool
            {
                return true;
            }
        };
    }

    public static function getParentInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'ParentInterface';

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : FieldSet
            {
                return new FieldSet([
                    new Field('name', Container::String()->notNull()),
                ]);
            }
        };
    }

    public static function getChildInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new InterfaceSet([
                    TestSchema::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : FieldSet
            {
                return new FieldSet([
                    new Field('number', Container::Int()->notNull()),
                ]);
            }
        };
    }

    public static function getSecondInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'SecondInterface';

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : FieldSet
            {
                return new FieldSet([
                    new Field(
                        'secondField',
                        Container::String()->notNull(),
                    ),
                ]);
            }
        };
    }

    public static function getChildType() : Type
    {
        return new class extends Type
        {
            protected const NAME = 'ChildType';

            public function __construct()
            {
                parent::__construct(new InterfaceSet([
                    TestSchema::getChildInterface(),
                    TestSchema::getSecondInterface(),
                ]));
            }

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }

            protected function getFieldDefinition() : ResolvableFieldSet
            {
                return new ResolvableFieldSet([
                    ResolvableField::create(
                        'name',
                        Container::String()->notNull(),
                        static function (\stdClass $parent, string $argName) : void {
                        },
                    ),
                    ResolvableField::create(
                        'number',
                        Container::Int()->notNull(),
                        static function (\stdClass $parent, string $argName) : void {
                        },
                    ),
                    ResolvableField::create(
                        'secondField',
                        Container::String()->notNull(),
                        static function (\stdClass $parent, string $argName) : void {
                        },
                    ),
                ]);
            }
        };
    }

    public static function getSimpleDirective() : Directive
    {
        return new class extends Directive implements FieldLocation
        {
            protected const NAME = 'simpleDirective';
            protected const REPEATABLE = true;

            public function resolveFieldBefore(ArgumentValueSet $arguments) : SelectionDirectiveResult
            {
            }

            public function resolveFieldAfter(ArgumentValueSet $arguments, FieldValue $fieldValue) : SelectionDirectiveResult
            {
            }

            public function validateFieldUsage(Field $field, ArgumentValueSet $arguments) : bool
            {
                return true;
            }

            protected function getFieldDefinition() : ArgumentSet
            {
                return new ArgumentSet([
                    Argument::create('reason', Container::String()),
                ]);
            }
        };
    }
}
