<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

use Graphpinator\Typesystem\Argument\Argument;
use Graphpinator\Typesystem\Argument\ArgumentSet;
use Graphpinator\Typesystem\Directive;
use Graphpinator\Typesystem\DirectiveUsage\DirectiveUsage;
use Graphpinator\Typesystem\DirectiveUsage\DirectiveUsageSet;
use Graphpinator\Typesystem\EnumItem\EnumItem;
use Graphpinator\Typesystem\EnumItem\EnumItemSet;
use Graphpinator\Typesystem\EnumType;
use Graphpinator\Typesystem\Field\Field;
use Graphpinator\Typesystem\Field\FieldSet;
use Graphpinator\Typesystem\InputType;
use Graphpinator\Typesystem\InterfaceSet;
use Graphpinator\Typesystem\InterfaceType;
use Graphpinator\Typesystem\ScalarType;
use Graphpinator\Typesystem\Schema;
use Graphpinator\Typesystem\Type;
use Graphpinator\Typesystem\UnionType;
use Graphpinator\Typesystem\Visitor\PrintNameVisitor;
use Graphpinator\Value\ArgumentValue;
use Graphpinator\Value\EnumValue;
use Graphpinator\Value\InputValue;
use Graphpinator\Value\InputedValue;
use Graphpinator\Value\ListInputedValue;
use Graphpinator\Value\NullValue;
use Graphpinator\Value\ScalarValue;

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

    #[\Override]
    public function visitSchema(Schema $schema) : string
    {
        $indentation = \str_repeat(' ', self::INDENT_SPACES);
        $mutationPart = $schema->getMutation() instanceof Type
            ? $indentation . 'mutation: ' . $schema->getMutation()->getName() . \PHP_EOL
            : '';
        $subscriptionPart = $schema->getSubscription() instanceof Type
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

    #[\Override]
    public function visitType(Type $type) : string
    {
        return $this->printDescription($type->getDescription())
            . 'type ' . $type->getName()
            . $this->printImplements($type->getInterfaces())
            . $this->printDirectiveUsages($type->getDirectiveUsages()) . ' {'
            . $this->printItems($this->fieldCollector->collect($type)) . \PHP_EOL
            . '}';
    }

    #[\Override]
    public function visitInterface(InterfaceType $interface) : string
    {
        return $this->printDescription($interface->getDescription())
            . 'interface ' . $interface->getName()
            . $this->printImplements($interface->getInterfaces())
            . $this->printDirectiveUsages($interface->getDirectiveUsages()) . ' {'
            . $this->printItems($this->fieldCollector->collect($interface)) . \PHP_EOL
            . '}';
    }

    #[\Override]
    public function visitUnion(UnionType $union) : string
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

    #[\Override]
    public function visitInput(InputType $input) : string
    {
        return $this->printDescription($input->getDescription())
            . 'input ' . $input->getName()
            . $this->printDirectiveUsages($input->getDirectiveUsages()) . ' {'
            . $this->printItems($input->getArguments()) . \PHP_EOL
            . '}';
    }

    #[\Override]
    public function visitScalar(ScalarType $scalar) : string
    {
        return $this->printDescription($scalar->getDescription())
            . 'scalar ' . $scalar->getName()
            . $this->printDirectiveUsages($scalar->getDirectiveUsages());
    }

    #[\Override]
    public function visitEnum(EnumType $enum) : string
    {
        return $this->printDescription($enum->getDescription())
            . 'enum ' . $enum->getName()
            . $this->printDirectiveUsages($enum->getDirectiveUsages()) . ' {'
            . $this->printItems($enum->getItems()) . \PHP_EOL
            . '}';
    }

    #[\Override]
    public function visitDirective(Directive $directive) : string
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

    #[\Override]
    public function visitField(Field $field) : string
    {
        $schema = $this->printItemDescription($field->getDescription())
            . $field->getName();

        if ($field->getArguments()->count() > 0) {
            $schema .= '(' . $this->printItems($field->getArguments()) . \PHP_EOL . ')';
        }

        return $schema . ': ' . $field->getType()->accept(new PrintNameVisitor()) . $this->printDirectiveUsages($field->getDirectiveUsages());
    }

    #[\Override]
    public function visitArgument(Argument $argument) : string
    {
        $schema = $this->printItemDescription($argument->getDescription())
            . $argument->getName() . ': ' . $argument->getType()->accept(new PrintNameVisitor());

        if ($argument->getDefaultValue() instanceof ArgumentValue) {
            $schema .= ' = ' . $this->printValue($argument->getDefaultValue()->getValue());
        }

        return $schema . $this->printDirectiveUsages($argument->getDirectiveUsages());
    }

    #[\Override]
    public function visitDirectiveUsage(DirectiveUsage $directiveUsage) : string
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

    #[\Override]
    public function visitEnumItem(EnumItem $enumItem) : string
    {
        return $this->printItemDescription($enumItem->getDescription())
            . $enumItem->getName() . $this->printDirectiveUsages($enumItem->getDirectiveUsages());
    }

    #[\Override]
    public function glue(array $entries) : string
    {
        return \implode(\PHP_EOL . \PHP_EOL, $entries);
    }

    /**
     * @return array<string>
     */
    private static function recursiveGetInterfaces(InterfaceSet $implements) : array
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

    private function printImplements(InterfaceSet $implements) : string
    {
        if (\count($implements) === 0) {
            return '';
        }

        return ' implements ' . \implode(' & ', self::recursiveGetInterfaces($implements));
    }

    private function printDirectiveUsages(DirectiveUsageSet $set) : string
    {
        $return = '';

        foreach ($set as $directiveUsage) {
            $return .= ' ' . $directiveUsage->accept($this);
        }

        return $return;
    }

    private function printItems(FieldSet|ArgumentSet|EnumItemSet $set) : string
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

    private function printValue(InputedValue $value, int $indentLevel = 0) : string
    {
        if ($value instanceof ScalarValue || $value instanceof EnumValue || $value instanceof NullValue) {
            return $value->printValue();
        }

        $component = [];
        $indentation = \str_repeat(' ', $indentLevel * self::INDENT_SPACES);
        $innerIndent = $indentation . \str_repeat(' ', self::INDENT_SPACES);

        if ($value instanceof InputValue) {
            $openingChar = '{';
            $closingChar = '}';

            foreach ($value as $key => $innerValue) {
                \assert($innerValue instanceof ArgumentValue);

                $component[] = $key . ': ' . $this->printValue($innerValue->getValue(), $indentLevel + 1);
            }
        } elseif ($value instanceof ListInputedValue) {
            $openingChar = '[';
            $closingChar = ']';

            foreach ($value as $innerValue) {
                \assert($innerValue instanceof InputedValue);

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
