<?php

declare(strict_types = 1);

namespace Graphpinator\Printer\Tests\Feature;

use Graphpinator\Printer\ImplicitInheritanceFieldCollector;
use Graphpinator\Printer\TextVisitor;
use Graphpinator\Typesystem\Argument\Argument;
use Graphpinator\Typesystem\Argument\ArgumentSet;
use Graphpinator\Typesystem\Container;
use Graphpinator\Typesystem\Contract\Entity;
use Graphpinator\Typesystem\Field\Field;
use Graphpinator\Typesystem\Field\FieldSet;
use Graphpinator\Typesystem\InterfaceSet;
use Graphpinator\Typesystem\InterfaceType;
use Graphpinator\Value\TypeIntermediateValue;
use PHPUnit\Framework\TestCase;

final class ImplicitInheritanceTest extends TestCase
{
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
                    Field::create(
                        'name',
                        Container::String(),
                    )->setArguments(new ArgumentSet([
                        Argument::create('arg', Container::String()->notNull())
                            ->setDefaultValue('abc'),
                    ])),
                    Field::create(
                        'surname',
                        Container::String(),
                    )->setArguments(new ArgumentSet([
                        Argument::create('arg', Container::String()->notNull()),
                    ]))->addDirective(
                        Container::directiveDeprecated(),
                    ),
                ]);
            }
        };
    }

    public static function getNewFieldInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
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

    public static function getNewArgumentInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : FieldSet
            {
                return new FieldSet([
                    Field::create(
                        'name',
                        Container::String(),
                    )->setArguments(new ArgumentSet([
                        Argument::create('arg', Container::String()->notNull())
                            ->setDefaultValue('abc'),
                        Argument::create('arg2', Container::String())
                            ->setDefaultValue(null),
                    ])),
                ]);
            }
        };
    }

    public static function getCovariantFieldInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : FieldSet
            {
                return new FieldSet([
                    Field::create(
                        'name',
                        Container::String()->notNull(),
                    )->setArguments(new ArgumentSet([
                        Argument::create('arg', Container::String()->notNull())
                            ->setDefaultValue('abc'),
                    ])),
                ]);
            }
        };
    }

    public static function getContravariantArgumentInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : FieldSet
            {
                return new FieldSet([
                    Field::create(
                        'name',
                        Container::String(),
                    )->setArguments(new ArgumentSet([
                        Argument::create('arg', Container::String())
                            ->setDefaultValue('abc'),
                    ])),
                ]);
            }
        };
    }

    public static function getDifferentDefaultInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : FieldSet
            {
                return new FieldSet([
                    Field::create(
                        'name',
                        Container::String(),
                    )->setArguments(new ArgumentSet([
                        Argument::create('arg', Container::String()->notNull())
                            ->setDefaultValue('xyz'),
                    ])),
                ]);
            }
        };
    }

    public static function getDifferentFieldDescInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : FieldSet
            {
                return new FieldSet([
                    Field::create(
                        'name',
                        Container::String(),
                    )->setArguments(new ArgumentSet([
                        Argument::create('arg', Container::String()->notNull())
                            ->setDefaultValue('abc'),
                    ]))->setDescription('Description'),
                ]);
            }
        };
    }

    public static function getDifferentArgumentDescInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : FieldSet
            {
                return new FieldSet([
                    Field::create(
                        'name',
                        Container::String(),
                    )->setArguments(new ArgumentSet([
                        Argument::create('arg', Container::String()->notNull())
                            ->setDefaultValue('abc')
                            ->setDescription('Description'),
                    ])),
                ]);
            }
        };
    }

    public static function getNewArgumentDefaultInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : FieldSet
            {
                return new FieldSet([
                    Field::create(
                        'surname',
                        Container::String(),
                    )->setArguments(new ArgumentSet([
                        Argument::create('arg', Container::String()->notNull())
                            ->setDefaultValue('abc'),
                    ]))->addDirective(
                        Container::directiveDeprecated(),
                    ),
                ]);
            }
        };
    }

    public static function getDirectiveArgumentInterface() : InterfaceType
    {
        return new class extends InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : FieldSet
            {
                return new FieldSet([
                    Field::create(
                        'surname',
                        Container::String(),
                    )->setArguments(new ArgumentSet([
                        Argument::create('arg', Container::String()->notNull()),
                    ]))->addDirective(
                        Container::directiveDeprecated(),
                        ['reason' => 'Some reason'],
                    ),
                ]);
            }
        };
    }

    public static function simpleDataProvider() : array
    {
        return [
            [
                self::getParentInterface(),
                <<<'EOL'
                interface ParentInterface {
                  name(
                    arg: String! = "abc"
                  ): String
                  surname(
                    arg: String!
                  ): String @deprecated
                }
                EOL,
            ],
            [
                self::getNewFieldInterface(),
                <<<'EOL'
                interface ChildInterface implements ParentInterface {
                  number: Int!
                }
                EOL,
            ],
            [
                self::getNewArgumentInterface(),
                <<<'EOL'
                interface ChildInterface implements ParentInterface {
                  name(
                    arg: String! = "abc"
                    arg2: String = null
                  ): String
                }
                EOL,
            ],
            [
                self::getCovariantFieldInterface(),
                <<<'EOL'
                interface ChildInterface implements ParentInterface {
                  name(
                    arg: String! = "abc"
                  ): String!
                }
                EOL,
            ],
            [
                self::getContravariantArgumentInterface(),
                <<<'EOL'
                interface ChildInterface implements ParentInterface {
                  name(
                    arg: String = "abc"
                  ): String
                }
                EOL,
            ],
            [
                self::getDifferentDefaultInterface(),
                <<<'EOL'
                interface ChildInterface implements ParentInterface {
                  name(
                    arg: String! = "xyz"
                  ): String
                }
                EOL,
            ],
            [
                self::getDifferentFieldDescInterface(),
                <<<'EOL'
                interface ChildInterface implements ParentInterface {
                  "Description"
                  name(
                    arg: String! = "abc"
                  ): String
                }
                EOL,
            ],
            [
                self::getDifferentArgumentDescInterface(),
                <<<'EOL'
                interface ChildInterface implements ParentInterface {
                  name(
                    "Description"
                    arg: String! = "abc"
                  ): String
                }
                EOL,
            ],
            [
                self::getDirectiveArgumentInterface(),
                <<<'EOL'
                interface ChildInterface implements ParentInterface {
                  surname(
                    arg: String!
                  ): String @deprecated(reason: "Some reason")
                }
                EOL,
            ],
            [
                self::getNewArgumentDefaultInterface(),
                <<<'EOL'
                interface ChildInterface implements ParentInterface {
                  surname(
                    arg: String! = "abc"
                  ): String @deprecated
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
        $visitor = new TextVisitor(
            new ImplicitInheritanceFieldCollector(),
        );
        self::assertSame($print, $type->accept($visitor));
    }
}
