<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

use Graphpinator\Typesystem\ComponentVisitor;

final class HtmlVisitor implements ComponentVisitor
{
    public function visitSchema(\Graphpinator\Type\Schema $schema) : string
    {
        $mutationName = $schema->getMutation() instanceof \Graphpinator\Type\Type
            ? $schema->getMutation()->getName()
            : 'null';
        $subscriptionName = $schema->getSubscription() instanceof \Graphpinator\Type\Type
            ? $schema->getSubscription()->getName()
            : 'null';
        $normalizedDescription = static::normalizeString($schema->getDescription());

        return <<<EOL
        <section>
            <div class="line">
                <span class="keyword" title="{$normalizedDescription}">schema</span>
                <span class="brace">{</span>
            </div>
            <div class="line offset-1">
                <span class="fieldname">query</span>
                <span class="colon">:</span>
                <a class="typename" href="#graphql-type-Query">{$schema->getQuery()->getName()}</a>
            </div>
            <div class="line offset-1">
                <span class="fieldname">mutation</span>
                <span class="colon">:</span>
                <a class="typename" href="#graphql-type-Mutation">{$mutationName}</a>
            </div>
            <div class="line offset-1">
                <span class="fieldname">subscription</span>
                <span class="colon">:</span>
                <span class="keyword">{$subscriptionName}</span>
            </div>
            <div class="line">
                <span class="brace">}</span>
            </div>
        </section>
        EOL;
    }

    public function visitType(\Graphpinator\Type\Type $type) : string
    {
        $normalizedDescription = static::normalizeString($type->getDescription());

        return <<<EOL
        <section>
            <div class="line">
                <span class="keyword" id="graphql-type-{$type->getName()}" title="{$normalizedDescription}">type</span>
                <span class="typename">{$type->getName()}</a>
                <span class="implements">{$this->printImplements($type->getInterfaces())}</span>
                <span class="usage">{$this->printDirectiveUsages($type->getDirectiveUsages())}</span>
                <span class="brace">{</span>
            </div>
            <div class="line">
                {$this->printItems($type->getFields())}
            </div>
            <div class="line">
                <span class="brace">}</span>
            </div>
        </section>
        EOL;
    }

    public function visitInterface(\Graphpinator\Type\InterfaceType $interface) : string
    {
        $normalizedDescription = static::normalizeString($interface->getDescription());

        return <<<EOL
        <section>
            <div class="line">
                <span class="keyword" id="graphql-interface-{$interface->getName()}" title="{$normalizedDescription}">interface</a>
                <span class="typename">{$interface->getName()}</span>
                <span class="implements">{$this->printImplements($interface->getInterfaces())}</span>
                <span class="usage">{$this->printDirectiveUsages($interface->getDirectiveUsages())}</span>
                <span class="brace">{</span>
            </div>
            <div class="line">
                {$this->printItems($interface->getFields())}
            </div>
            <div class="line">
                <span class="brace">}</span>
            </div>
        </section>
        EOL;

    }

    public function visitUnion(\Graphpinator\Type\UnionType $union) : string
    {
        $normalizedDescription = static::normalizeString($union->getDescription());
        $typeNames = [];

        foreach ($union->getTypes() as $type) {
            $typeNames[] = $type->getName();
        }

        $types = \implode(' | ', $typeNames);

        return <<<EOL
        <section>
            <div class="line">
                <span class="keyword" id="graphql-union-{$union->getName()}" title="{$normalizedDescription}">union</span>
                <span class="typename">{$union->getName()} = {$types}</span>
            </div>
        </section>
        EOL;
    }

    public function visitInput(\Graphpinator\Type\InputType $input) : string
    {
        $normalizedDescription = static::normalizeString($input->getDescription());

        return <<<EOL
        <section>
            <div class="line">
                <span class="keyword" id="graphql-input-{$input->getName()}" title="{$normalizedDescription}">input</span>
                <span class="typename">{$input->getName()}</span>
                <span class="usage">{$this->printDirectiveUsages($input->getDirectiveUsages())}</span>
                <span class="brace">{</span>
            </div>
            <div class="line offset-1">
                {$this->printItems($input->getArguments())}
            </div>
            <div class="line">
                <span class="brace">}</span>
            </div>
        </section>
        EOL;
    }

    public function visitScalar(\Graphpinator\Type\ScalarType $scalar) : string
    {
        $normalizedDescription = static::normalizeString($scalar->getDescription());

        return <<<EOL
        <section>
            <div class="line">
                <span class="keyword" id="graphql-scalar-{$scalar->getName()}" title="{$normalizedDescription}">scalar</span>
                <span class="typename">{$scalar->getName()}</span>
            </div>
        </section>
        EOL;
    }

    public function visitEnum(\Graphpinator\Type\EnumType $enum) : string
    {
        $normalizedDescription = static::normalizeString($enum->getDescription());

        return <<<EOL
        <section>
            <div class="line">
                <span class="keyword" id="graphql-enum-{$enum->getName()}" title="{$normalizedDescription}">enum</span>
                <span class="typename">{$enum->getName()}</span>
                <span class="brace">{</span>
            </div>
            <div class="line offset-1">
                {$this->printItems($enum->getItems())}
            </div>
            <div class="line">
                <span class="brace">}</span>
            </div>
        </section>
        EOL;
    }

    public function visitDirective(\Graphpinator\Directive\Directive $directive) : string
    {
        $directiveAdditional = '';
        $normalizedDescription = static::normalizeString($directive->getDescription());

        if ($directive->getArguments()->count() > 0) {
            $directiveAdditional .= '<span class="brace-round">(</span>';
            $directiveAdditional .= '<div class="offset-1">' . $this->printItems($directive->getArguments()) . '</div>';
            $directiveAdditional .= '<span class="brace-round">)</span>';
        }

        if ($directive->isRepeatable()) {
            $directiveAdditional .= ' <span class="keyword">repeatable</span>';
        }

        $directiveAdditional .= '<span class="keyword"> on </span>';
        $directiveAdditional .= '<span class="location">' . \implode(' | ', $directive->getLocations()) . '</span>';

        return <<<EOL
        <section>
            <div class="line">
                <span class="keyword" id="graphql-directive-{$directive->getName()}" title="{$normalizedDescription}">directive @</span>
                <span class="typename">{$directive->getName()}</span>
                {$directiveAdditional}
            </div>
        </section>
        EOL;
    }

    public function visitField(\Graphpinator\Field\Field $field) : string
    {
        $arguments = '';
        $translatedType = static::translateType($field->getType());
        $normalizedDescription = static::normalizeString($field->getDescription());

        if ($field->getArguments()->count() > 0) {
            $arguments .= '<span class="brace-round">(</span>';
            $arguments .= '<div class="line offset-1">' . $this->printItems($field->getArguments()) . '</div>';
            $arguments .= '<span class="brace-round">)</span>';
        }

        return <<<EOL
        <div class="line offset-1">
            <span class="fieldname" id="graphql-field-{$field->getName()}">{$field->getName()}</span>
            <span class="arguments">{$arguments}</span>
            <span class="colon">:</span>
            <a class="typename" href="#graphql-{$translatedType}-{$field->getType()->getShapingType()->getNamedType()->printName()}" 
                title="{$normalizedDescription}">{$field->getType()->printName()}</a>
            {$this->printDirectiveUsages($field->getDirectiveUsages())}
        </div>
        EOL;
    }

    public function visitArgument(\Graphpinator\Argument\Argument $argument) : string
    {
        $translatedType = static::translateType($argument->getType());
        $defaultValue = '';

        if ($argument->getDefaultValue() instanceof \Graphpinator\Value\ArgumentValue) {
            $defaultValue .= ' <span class="equals">=</span> ';
            $defaultValue .= '<span class="argument-value">' . $this->printValue($argument->getDefaultValue()->getValue()) . '</span>';
        }

        return <<<EOL
            <span class="argument-name">{$argument->getName()}</span>
            <span class="colon">:</span>
            <a class="typename" href="#graphql-{$translatedType}-{$argument->getType()->getShapingType()->getNamedType()->printName()}">{$argument->getType()->printName()}</a>
            {$defaultValue}
            {$this->printDirectiveUsages($argument->getDirectiveUsages())}
        EOL;
    }

    public function visitDirectiveUsage(\Graphpinator\DirectiveUsage\DirectiveUsage $directiveUsage) : string
    {
        $schema = '<span class="typename">@' . $directiveUsage->getDirective()->getName() . '</span>';
        $printableArguments = [];

        foreach ($directiveUsage->getArgumentValues() as $argument) {
            // do not print default value
            if ($argument->getValue()->getRawValue() === $argument->getArgument()->getDefaultValue()?->getValue()->getRawValue()) {
                continue;
            }

            $printableArgument = '<span class="directive-usage-name">' . $argument->getArgument()->getName() . '</span>';
            $printableArgument .= '<span class="colon">:</span> ';
            $printableArgument .= '<span class="directive-usage-value">' . $argument->getValue()->printValue() . '</span>';

            $printableArguments[] =  $printableArgument;
        }

        if (\count($printableArguments)) {
            $schema .= '<span class="brace-round">(</span>' . \implode('<span class="comma">,</span> ', $printableArguments) . '<span class="brace-round">)</span>';
        }

        return $schema;
    }

    public function visitEnumItem(\Graphpinator\EnumItem\EnumItem $enumItem) : string
    {
        $normalizedDescription = static::normalizeString($enumItem->getDescription());

        return <<<EOL
            <span class="enumitem line" title="{$normalizedDescription}">{$enumItem->getName()} {$this->printDirectiveUsages($enumItem->getDirectiveUsages())}</span>
        EOL;
    }

    private function printImplements(\Graphpinator\Type\InterfaceSet $implements) : string
    {
        if (\count($implements) === 0) {
            return '';
        }

        $interfaces = [];

        foreach ($implements as $interface) {
            $interfaces[] = '<a class="typename" href="#graphql-interface-' . $interface->getName() . '">' . $interface->getName() . '</a>';
        }

        return ' implements ' . \implode(' & ', $interfaces);
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

        foreach ($set as $item) {
            $result .= '<span class="line item">' . $item->accept($this) . '</span>';
        }

        return $result;
    }

    private function printLeafValue(\Graphpinator\Value\InputedValue $value)
    {
        if ($value instanceof \Graphpinator\Value\NullValue) {
            $className = 'null';
        }

        if ($value instanceof \Graphpinator\Value\EnumValue) {
            $className = 'enumliteral';
        }

        if ($value instanceof \Graphpinator\Value\ScalarValue) {
            $rawValue = $value->getRawValue();

            if (\is_bool($rawValue)) {
                $className = $rawValue ? 'true' : 'false';
            }

            if (\is_int($rawValue)) {
                $className = 'intliteral';
            }

            if (\is_float($rawValue)) {
                $className = 'floatliteral';
            }
        }

        return <<<EOL
                <span class="{$className}">{$value->printValue()}</span>
        EOL;
    }

    private function printValue(\Graphpinator\Value\InputedValue $value) : string
    {
        if ($value instanceof \Graphpinator\Value\LeafValue || $value instanceof \Graphpinator\Value\NullValue) {
            return $this->printLeafValue($value);
        }

        $component = [];

        if ($value instanceof \Graphpinator\Value\InputValue) {
            $openingChar = '<span class="brace-curly">{</span>';
            $closingChar = '<span class="brace-curly">}</span>';

            foreach ($value as $key => $innerValue) {
                \assert($innerValue instanceof \Graphpinator\Value\ArgumentValue);

                $component[] = '<span class="value-name">' . $key . '</span><span class="colon">:</span> ' . $this->printValue($innerValue->getValue());
            }
        } elseif ($value instanceof \Graphpinator\Value\ListInputedValue) {
            $openingChar = '<span class="brace-square">[</span>';
            $closingChar = '<span class="brace-square">]</span>';

            foreach ($value as $innerValue) {
                \assert($innerValue instanceof \Graphpinator\Value\InputedValue);

                $component[] = $this->printValue($innerValue);
            }
        } else {
            throw new \InvalidArgumentException('Unknown value type.');
        }

        if (\count($component) === 0) {
            return $openingChar . $closingChar;
        }

        $components = \implode('<span class="comma">,</span>', $component);

        return <<<EOL
                {$openingChar}<span class="value">{$components}</span>{$closingChar}
        EOL;
    }

    private static function translateType(\Graphpinator\Type\Contract\Outputable|\Graphpinator\Type\Contract\Inputable $outputable) : string
    {
        if ($outputable->getShapingType() instanceof \Graphpinator\Type\ScalarType) {
            return 'scalar';
        }

        if ($outputable->getShapingType() instanceof \Graphpinator\Type\EnumType) {
            return 'enum';
        }

        if ($outputable->getShapingType() instanceof \Graphpinator\Type\Type) {
            return 'type';
        }

        if ($outputable->getShapingType() instanceof \Graphpinator\Type\InterfaceType) {
            return 'interface';
        }

        if ($outputable->getShapingType() instanceof \Graphpinator\Type\ListType) {
            return static::translateType($outputable->getShapingType()->getNamedType());
        }

        if ($outputable->getShapingType() instanceof \Graphpinator\Type\UnionType) {
            return 'union';
        }

        if ($outputable->getShapingType() instanceof \Graphpinator\Type\InputType) {
            return 'input';
        }

        return '?';
    }

    private static function normalizeString(?string $input) : string
    {
        if (!\is_string($input)) {
            return '';
        }

        return \htmlspecialchars($input);
    }
}
