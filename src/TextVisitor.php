<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

final class TextVisitor implements PrintComponentVisitor
{
    private const INDENT_SPACES = 2;

    private FieldCollector $fieldCollector;

    public function __construct(
        ?FieldCollector $fieldCollector = null,
    )
    {
        $this->fieldCollector = $fieldCollector
            ?? new AllFieldCollector();
    }

    public function visitSchema(\Graphpinator\Typesystem\Schema $schema) : string
    {
        $indentation = \str_repeat(' ', self::INDENT_SPACES);
        $mutationPart = $schema->getMutation() instanceof \Graphpinator\Typesystem\Type
            ? $indentation . 'mutation: ' . $schema->getMutation()->getName() . \PHP_EOL
            : '';
        $subscriptionPart = $schema->getSubscription() instanceof \Graphpinator\Typesystem\Type
            ? $indentation . 'subscription: ' . $schema->getSubscription()->getName() . \PHP_EOL
            : '';

        return $this->printDescription($schema->getDescription())
            . 'schema'
            . $this->printDirectiveUsages($schema->getDirectiveUsages()) . ' {' . \PHP_EOL
            . $indentation . 'query: ' . $schema->getQuery()->getName() . \PHP_EOL
            . $mutationPart
            . $subscriptionPart
            . '}';
    }

    public function visitType(\Graphpinator\Typesystem\Type $type) : string
    {
        return $this->printDescription($type->getDescription())
            . 'type ' . $type->getName()
            . $this->printImplements($type->getInterfaces())
            . $this->printDirectiveUsages($type->getDirectiveUsages()) . ' {'
            . $this->printItems($this->fieldCollector->collect($type)) . \PHP_EOL
            . '}';
    }

    public function visitInterface(\Graphpinator\Typesystem\InterfaceType $interface) : string
    {
        return $this->printDescription($interface->getDescription())
            . 'interface ' . $interface->getName()
            . $this->printImplements($interface->getInterfaces())
            . $this->printDirectiveUsages($interface->getDirectiveUsages()) . ' {'
            . $this->printItems($this->fieldCollector->collect($interface)) . \PHP_EOL
            . '}';
    }

    public function visitUnion(\Graphpinator\Typesystem\UnionType $union) : string
    {
        $typeNames = [];

        foreach ($union->getTypes() as $type) {
            $typeNames[] = $type->getName();
        }

        return $this->printDescription($union->getDescription())
            . 'union ' . $union->getName()
            . $this->printDirectiveUsages($union->getDirectiveUsages())
            . ' = ' . \implode(' | ', $typeNames);
    }

    public function visitInput(\Graphpinator\Typesystem\InputType $input) : string
    {
        return $this->printDescription($input->getDescription())
            . 'input ' . $input->getName()
            . $this->printDirectiveUsages($input->getDirectiveUsages()) . ' {'
            . $this->printItems($input->getArguments()) . \PHP_EOL
            . '}';
    }

    public function visitScalar(\Graphpinator\Typesystem\ScalarType $scalar) : string
    {
        return $this->printDescription($scalar->getDescription())
            . 'scalar ' . $scalar->getName()
            . $this->printDirectiveUsages($scalar->getDirectiveUsages());
    }

    public function visitEnum(\Graphpinator\Typesystem\EnumType $enum) : string
    {
        return $this->printDescription($enum->getDescription())
            . 'enum ' . $enum->getName()
            . $this->printDirectiveUsages($enum->getDirectiveUsages()) . ' {'
            . $this->printItems($enum->getItems()) . \PHP_EOL
            . '}';
    }

    public function visitDirective(\Graphpinator\Typesystem\Directive $directive) : string
    {
        $schema = $this->printDescription($directive->getDescription())
            . 'directive @' . $directive->getName();

        if ($directive->getArguments()->count() > 0) {
            $schema .= '(' . $this->printItems($directive->getArguments()) . \PHP_EOL . ')';
        }

        if ($directive->isRepeatable()) {
            $schema .= ' repeatable';
        }

        return $schema . ' on ' . \implode(' | ', \array_column($directive->getLocations(), 'value'));
    }

    public function visitField(\Graphpinator\Typesystem\Field\Field $field) : string
    {
        $schema = $this->printItemDescription($field->getDescription())
            . $field->getName();

        if ($field->getArguments()->count() > 0) {
            $schema .= '(' . $this->printItems($field->getArguments()) . \PHP_EOL . ')';
        }

        return $schema . ': ' . $field->getType()->printName() . $this->printDirectiveUsages($field->getDirectiveUsages());
    }

    public function visitArgument(\Graphpinator\Typesystem\Argument\Argument $argument) : string
    {
        $schema = $this->printItemDescription($argument->getDescription())
            . $argument->getName() . ': ' . $argument->getType()->printName();

        if ($argument->getDefaultValue() instanceof \Graphpinator\Value\ArgumentValue) {
            $schema .= ' = ' . $this->printValue($argument->getDefaultValue()->getValue());
        }

        return $schema . $this->printDirectiveUsages($argument->getDirectiveUsages());
    }

    public function visitDirectiveUsage(\Graphpinator\Typesystem\DirectiveUsage\DirectiveUsage $directiveUsage) : string
    {
        $schema = '@' . $directiveUsage->getDirective()->getName();
        $printableArguments = [];

        foreach ($directiveUsage->getArgumentValues() as $argument) {
            // do not print default value
            if ($argument->getValue()->getRawValue() === $argument->getArgument()->getDefaultValue()?->getValue()->getRawValue()) {
                continue;
            }

            $printableArguments[] = $argument->getArgument()->getName() . ': ' . $argument->getValue()->printValue();
        }

        if (\count($printableArguments)) {
            $schema .= '(' . \implode(', ', $printableArguments) . ')';
        }

        return $schema;
    }

    public function visitEnumItem(\Graphpinator\Typesystem\EnumItem\EnumItem $enumItem) : string
    {
        return $this->printItemDescription($enumItem->getDescription())
            . $enumItem->getName() . $this->printDirectiveUsages($enumItem->getDirectiveUsages());
    }

    public function glue(array $entries) : string
    {
        return \implode(\PHP_EOL . \PHP_EOL, $entries);
    }

    /**
     * @return array<string>
     */
    private static function recursiveGetInterfaces(\Graphpinator\Typesystem\InterfaceSet $implements) : array
    {
        $return = [];

        foreach ($implements as $interface) {
            $return += self::recursiveGetInterfaces($interface->getInterfaces());
            $return[] = $interface->getName();
        }

        return $return;
    }

    private function printDescription(?string $description) : string
    {
        if ($description === null) {
            return '';
        }

        return '"""' . \PHP_EOL . $description . \PHP_EOL . '"""' . \PHP_EOL;
    }

    private function printItemDescription(?string $description) : string
    {
        if ($description === null) {
            return '';
        }

        if (!\str_contains($description, \PHP_EOL)) {
            return '"' . $description . '"' . \PHP_EOL;
        }

        return '"""' . \PHP_EOL . $description . \PHP_EOL . '"""' . \PHP_EOL;
    }

    private function printImplements(\Graphpinator\Typesystem\InterfaceSet $implements) : string
    {
        if (\count($implements) === 0) {
            return '';
        }

        return ' implements ' . \implode(' & ', self::recursiveGetInterfaces($implements));
    }

    private function printDirectiveUsages(\Graphpinator\Typesystem\DirectiveUsage\DirectiveUsageSet $set) : string
    {
        $return = '';

        foreach ($set as $directiveUsage) {
            $return .= ' ' . $directiveUsage->accept($this);
        }

        return $return;
    }

    private function printItems(
        \Graphpinator\Typesystem\Field\FieldSet|\Graphpinator\Typesystem\Argument\ArgumentSet|\Graphpinator\Typesystem\EnumItem\EnumItemSet $set,
    ) : string
    {
        $result = '';
        $previousHasDescription = false;
        $isFirst = true;

        foreach ($set as $item) {
            $currentHasDescription = $item->getDescription() !== null;

            if (!$isFirst && ($previousHasDescription || $currentHasDescription)) {
                $result .= \PHP_EOL;
            }

            $result .= \PHP_EOL . $item->accept($this);
            $previousHasDescription = $currentHasDescription;
            $isFirst = false;
        }

        $indentation = \str_repeat(' ', self::INDENT_SPACES);
        // replace newline with newline and indent, but not for empty line
        $result = \preg_replace('/\\n(?!\\n)/', \PHP_EOL . $indentation, $result);

        return $result;
    }

    private function printValue(\Graphpinator\Value\InputedValue $value, int $indentLevel = 0) : string
    {
        if ($value instanceof \Graphpinator\Value\LeafValue || $value instanceof \Graphpinator\Value\NullValue) {
            return $value->printValue();
        }

        $component = [];
        $indentation = \str_repeat(' ', $indentLevel * self::INDENT_SPACES);
        $innerIndent = $indentation . \str_repeat(' ', self::INDENT_SPACES);

        if ($value instanceof \Graphpinator\Value\InputValue) {
            $openingChar = '{';
            $closingChar = '}';

            foreach ($value as $key => $innerValue) {
                \assert($innerValue instanceof \Graphpinator\Value\ArgumentValue);

                $component[] = $key . ': ' . $this->printValue($innerValue->getValue(), $indentLevel + 1);
            }
        } elseif ($value instanceof \Graphpinator\Value\ListInputedValue) {
            $openingChar = '[';
            $closingChar = ']';

            foreach ($value as $innerValue) {
                \assert($innerValue instanceof \Graphpinator\Value\InputedValue);

                $component[] = $this->printValue($innerValue, $indentLevel + 1);
            }
        } else {
            throw new \InvalidArgumentException('Unknown value type.');
        }

        if (\count($component) === 0) {
            return $openingChar . $closingChar;
        }

        return $openingChar . \PHP_EOL
            . $innerIndent . \implode(',' . \PHP_EOL . $innerIndent, $component) . \PHP_EOL
            . $indentation . $closingChar;
    }
}
