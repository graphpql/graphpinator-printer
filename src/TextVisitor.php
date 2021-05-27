<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

final class TextVisitor implements PrintComponentVisitor
{
    private const INDENT_SPACES = 2;

    public function visitSchema(\Graphpinator\Type\Schema $schema) : string
    {
        $mutationName = $schema->getMutation() instanceof \Graphpinator\Type\Type
            ? $schema->getMutation()->getName()
            : 'null';
        $subscriptionName = $schema->getSubscription() instanceof \Graphpinator\Type\Type
            ? $schema->getSubscription()->getName()
            : 'null';

        return $this->printDescription($schema->getDescription()) . <<<EOL
        schema {
          query: {$schema->getQuery()->getName()}
          mutation: {$mutationName}
          subscription: {$subscriptionName}
        }
        EOL;
    }

    public function visitType(\Graphpinator\Type\Type $type) : string
    {
        return $this->printDescription($type->getDescription())
            . 'type ' . $type->getName()
            . $this->printImplements($type->getInterfaces())
            . $this->printDirectiveUsages($type->getDirectiveUsages()) . ' {'
            . $this->printItems($type->getFields()) . \PHP_EOL
            . '}';
    }

    public function visitInterface(\Graphpinator\Type\InterfaceType $interface) : string
    {
        return $this->printDescription($interface->getDescription())
            . 'interface ' . $interface->getName()
            . $this->printImplements($interface->getInterfaces())
            . $this->printDirectiveUsages($interface->getDirectiveUsages()) . ' {'
            . $this->printItems($interface->getFields()) . \PHP_EOL
            . '}';
    }

    public function visitUnion(\Graphpinator\Type\UnionType $union) : string
    {
        $typeNames = [];

        foreach ($union->getTypes() as $type) {
            $typeNames[] = $type->getName();
        }

        return $this->printDescription($union->getDescription())
            . 'union ' . $union->getName() . ' = ' . \implode(' | ', $typeNames);
    }

    public function visitInput(\Graphpinator\Type\InputType $input) : string
    {
        return $this->printDescription($input->getDescription())
            . 'input ' . $input->getName()
            . $this->printDirectiveUsages($input->getDirectiveUsages()) . ' {'
            . $this->printItems($input->getArguments()) . \PHP_EOL
            . '}';
    }

    public function visitScalar(\Graphpinator\Type\ScalarType $scalar) : string
    {
        return $this->printDescription($scalar->getDescription())
            . 'scalar ' . $scalar->getName();
    }

    public function visitEnum(\Graphpinator\Type\EnumType $enum) : string
    {
        return $this->printDescription($enum->getDescription())
            . 'enum ' . $enum->getName() . ' {'
            . $this->printItems($enum->getItems()) . \PHP_EOL
            . '}';
    }

    public function visitDirective(\Graphpinator\Directive\Directive $directive) : string
    {
        $schema = $this->printDescription($directive->getDescription())
            . 'directive @' . $directive->getName();

        if ($directive->getArguments()->count() > 0) {
            $schema .= '(' . $this->printItems($directive->getArguments()) . \PHP_EOL . ')';
        }

        if ($directive->isRepeatable()) {
            $schema .= ' repeatable';
        }

        return $schema . ' on ' . \implode(' | ', $directive->getLocations());
    }

    public function visitField(\Graphpinator\Field\Field $field) : string
    {
        $schema = $this->printItemDescription($field->getDescription())
            . $field->getName();

        if ($field->getArguments()->count() > 0) {
            $schema .= '(' . $this->printItems($field->getArguments()) . \PHP_EOL . ')';
        }

        return $schema . ': ' . $field->getType()->printName() . $this->printDirectiveUsages($field->getDirectiveUsages());
    }

    public function visitArgument(\Graphpinator\Argument\Argument $argument) : string
    {
        $schema = $this->printItemDescription($argument->getDescription())
            . $argument->getName() . ': ' . $argument->getType()->printName();

        if ($argument->getDefaultValue() instanceof \Graphpinator\Value\ArgumentValue) {
            $schema .= ' = ' . $this->printValue($argument->getDefaultValue()->getValue());
        }

        return $schema . $this->printDirectiveUsages($argument->getDirectiveUsages());
    }

    public function visitDirectiveUsage(\Graphpinator\DirectiveUsage\DirectiveUsage $directiveUsage) : string
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

    public function visitEnumItem(\Graphpinator\EnumItem\EnumItem $enumItem) : string
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
    private static function recursiveGetInterfaces(\Graphpinator\Type\InterfaceSet $implements) : array
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

    private function printImplements(\Graphpinator\Type\InterfaceSet $implements) : string
    {
        if (\count($implements) === 0) {
            return '';
        }

        return ' implements ' . \implode(' & ', self::recursiveGetInterfaces($implements));
    }

    private function printDirectiveUsages(\Graphpinator\DirectiveUsage\DirectiveUsageSet $set) : string
    {
        $return = '';

        foreach ($set as $directiveUsage) {
            $return .= ' ' . $directiveUsage->accept($this);
        }

        return $return;
    }

    private function printItems(
        \Graphpinator\Field\FieldSet|\Graphpinator\Argument\ArgumentSet|\Graphpinator\EnumItem\EnumItemSet $set,
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
