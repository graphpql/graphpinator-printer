<?php

declare(strict_types = 1);

namespace Graphpinator\Printer\Tests\Feature;

final class ImplicitInheritanceTest extends \PHPUnit\Framework\TestCase
{
    public static function getParentInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ParentInterface';

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    \Graphpinator\Typesystem\Field\Field::create(
                        'name',
                        \Graphpinator\Typesystem\Container::String(),
                    )->setArguments(new \Graphpinator\Typesystem\Argument\ArgumentSet([
                        \Graphpinator\Typesystem\Argument\Argument::create('arg', \Graphpinator\Typesystem\Container::String()->notNull())
                            ->setDefaultValue('abc'),
                    ])),
                    \Graphpinator\Typesystem\Field\Field::create(
                        'surname',
                        \Graphpinator\Typesystem\Container::String(),
                    )->setArguments(new \Graphpinator\Typesystem\Argument\ArgumentSet([
                        \Graphpinator\Typesystem\Argument\Argument::create('arg', \Graphpinator\Typesystem\Container::String()->notNull()),
                    ]))->addDirective(
                        \Graphpinator\Typesystem\Container::directiveDeprecated(),
                    ),
                ]);
            }
        };
    }

    public static function getNewFieldInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
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

    public static function getNewArgumentInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    \Graphpinator\Typesystem\Field\Field::create(
                        'name',
                        \Graphpinator\Typesystem\Container::String(),
                    )->setArguments(new \Graphpinator\Typesystem\Argument\ArgumentSet([
                        \Graphpinator\Typesystem\Argument\Argument::create('arg', \Graphpinator\Typesystem\Container::String()->notNull())
                            ->setDefaultValue('abc'),
                        \Graphpinator\Typesystem\Argument\Argument::create('arg2', \Graphpinator\Typesystem\Container::String())
                            ->setDefaultValue(null),
                    ])),
                ]);
            }
        };
    }

    public static function getCovariantFieldInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    \Graphpinator\Typesystem\Field\Field::create(
                        'name',
                        \Graphpinator\Typesystem\Container::String()->notNull(),
                    )->setArguments(new \Graphpinator\Typesystem\Argument\ArgumentSet([
                        \Graphpinator\Typesystem\Argument\Argument::create('arg', \Graphpinator\Typesystem\Container::String()->notNull())
                            ->setDefaultValue('abc'),
                    ])),
                ]);
            }
        };
    }

    public static function getContravariantArgumentInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    \Graphpinator\Typesystem\Field\Field::create(
                        'name',
                        \Graphpinator\Typesystem\Container::String(),
                    )->setArguments(new \Graphpinator\Typesystem\Argument\ArgumentSet([
                        \Graphpinator\Typesystem\Argument\Argument::create('arg', \Graphpinator\Typesystem\Container::String())
                            ->setDefaultValue('abc'),
                    ])),
                ]);
            }
        };
    }

    public static function getDifferentDefaultInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    \Graphpinator\Typesystem\Field\Field::create(
                        'name',
                        \Graphpinator\Typesystem\Container::String(),
                    )->setArguments(new \Graphpinator\Typesystem\Argument\ArgumentSet([
                        \Graphpinator\Typesystem\Argument\Argument::create('arg', \Graphpinator\Typesystem\Container::String()->notNull())
                            ->setDefaultValue('xyz'),
                    ])),
                ]);
            }
        };
    }

    public static function getDifferentFieldDescInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    \Graphpinator\Typesystem\Field\Field::create(
                        'name',
                        \Graphpinator\Typesystem\Container::String(),
                    )->setArguments(new \Graphpinator\Typesystem\Argument\ArgumentSet([
                        \Graphpinator\Typesystem\Argument\Argument::create('arg', \Graphpinator\Typesystem\Container::String()->notNull())
                            ->setDefaultValue('abc'),
                    ]))->setDescription('Description'),
                ]);
            }
        };
    }

    public static function getDifferentArgumentDescInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    \Graphpinator\Typesystem\Field\Field::create(
                        'name',
                        \Graphpinator\Typesystem\Container::String(),
                    )->setArguments(new \Graphpinator\Typesystem\Argument\ArgumentSet([
                        \Graphpinator\Typesystem\Argument\Argument::create('arg', \Graphpinator\Typesystem\Container::String()->notNull())
                            ->setDefaultValue('abc')
                            ->setDescription('Description'),
                    ])),
                ]);
            }
        };
    }

    public static function getNewArgumentDefaultInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    \Graphpinator\Typesystem\Field\Field::create(
                        'surname',
                        \Graphpinator\Typesystem\Container::String(),
                    )->setArguments(new \Graphpinator\Typesystem\Argument\ArgumentSet([
                        \Graphpinator\Typesystem\Argument\Argument::create('arg', \Graphpinator\Typesystem\Container::String()->notNull())
                            ->setDefaultValue('abc'),
                    ]))->addDirective(
                        \Graphpinator\Typesystem\Container::directiveDeprecated(),
                    ),
                ]);
            }
        };
    }

    public static function getDirectiveArgumentInterface() : \Graphpinator\Typesystem\InterfaceType
    {
        return new class extends \Graphpinator\Typesystem\InterfaceType
        {
            protected const NAME = 'ChildInterface';

            public function __construct()
            {
                parent::__construct(new \Graphpinator\Typesystem\InterfaceSet([
                    ImplicitInheritanceTest::getParentInterface(),
                ]));
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
            }

            protected function getFieldDefinition() : \Graphpinator\Typesystem\Field\FieldSet
            {
                return new \Graphpinator\Typesystem\Field\FieldSet([
                    \Graphpinator\Typesystem\Field\Field::create(
                        'surname',
                        \Graphpinator\Typesystem\Container::String(),
                    )->setArguments(new \Graphpinator\Typesystem\Argument\ArgumentSet([
                        \Graphpinator\Typesystem\Argument\Argument::create('arg', \Graphpinator\Typesystem\Container::String()->notNull()),
                    ]))->addDirective(
                        \Graphpinator\Typesystem\Container::directiveDeprecated(),
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
     * @param \Graphpinator\Typesystem\Contract\Entity $type
     * @param string $print
     */
    public function testSimple(\Graphpinator\Typesystem\Contract\Entity $type, string $print) : void
    {
        $visitor = new \Graphpinator\Printer\TextVisitor(
            new \Graphpinator\Printer\ImplicitInheritanceFieldCollector(),
        );
        self::assertSame($print, $type->accept($visitor));
    }
}
