<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

final class HtmlVisitor implements PrintComponentVisitor
{
    public function visitSchema(\Graphpinator\Type\Schema $schema) : string
    {
        $normalizedDescription = static::normalizeString($schema->getDescription());

        if ($schema->getMutation() instanceof \Graphpinator\Type\Type) {
            $mutation = '<span class="fieldname">mutation</span>';
            $mutation .= '<span class="colon">:&nbsp;</span>';
            $mutation .= '<a class="fieldtype" href="#graphql-type-' . $schema->getMutation()->getName() . '">' . $schema->getMutation()->getName() . '</a>';
        } else {
            $mutation = '<span class="fieldname">mutation</span>';
            $mutation .= '<span class="colon">:&nbsp;</span>';
            $mutation .= '<span class="null">null</span>';
        }

        if ($schema->getSubscription() instanceof \Graphpinator\Type\Type) {
            $subscription = '<span class="fieldname">subscription</span>';
            $subscription .= '<span class="colon">:&nbsp;</span>';
            $subscription .= '<a class="fieldtype" href="#graphql-type-' . $schema->getSubscription()->getName() . '">' . $schema->getSubscription()->getName() . '</a>';
        } else {
            $subscription = '<span class="fieldname">subscription</span>';
            $subscription .= '<span class="colon">:&nbsp;</span>';
            $subscription .= '<span class="null">null</span>';
        }

        return <<<EOL
        <section>
            <div class="line">
                <span class="keyword" title="{$normalizedDescription}">schema&nbsp;</span>
                <span class="bracket-curly">{</span>
            </div>
            <div class="line offset-1">
                <span class="fieldname">query</span>
                <span class="colon">:&nbsp;</span>
                <a class="fieldtype" href="#graphql-type-Query">{$schema->getQuery()->getName()}</a>
            </div>
            <div class="line offset-1">
                {$mutation}
            </div>
            <div class="line offset-1">
                {$subscription}
            </div>
            <div class="line">
                <span class="bracket-curly">}</span>
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
                <span class="keyword" id="graphql-type-{$type->getName()}" title="{$normalizedDescription}">type&nbsp;</span>
                <span class="typename">{$type->getName()}</span>
                <span class="implements">{$this->printImplements($type->getInterfaces())}</span>
                <span class="usage">{$this->printDirectiveUsages($type->getDirectiveUsages())}</span>
                <span class="bracket-curly">&nbsp;{</span>
            </div>
            <div class="line">
                {$this->printItems($type->getFields())}
            </div>
            <div class="line">
                <span class="bracket-curly">}</span>
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
                <span class="keyword" id="graphql-type-{$interface->getName()}" title="{$normalizedDescription}">interface&nbsp;</span>
                <span class="typename">{$interface->getName()}</span>
                <span class="implements">{$this->printImplements($interface->getInterfaces())}</span>
                <span class="usage">{$this->printDirectiveUsages($interface->getDirectiveUsages())}</span>
                <span class="bracket-curly">&nbsp;{</span>
            </div>
            <div class="line">
                {$this->printItems($interface->getFields())}
            </div>
            <div class="line">
                <span class="bracket-curly">}</span>
            </div>
        </section>
        EOL;
    }

    public function visitUnion(\Graphpinator\Type\UnionType $union) : string
    {
        $normalizedDescription = static::normalizeString($union->getDescription());
        $typeNames = [];

        foreach ($union->getTypes() as $type) {
            $typeNames[] = '<a class="uniontype" href="#graphql-type-' . $type->getName() . '">' . $type->getName() . '</a>';
        }

        $types = \implode('&nbsp;<span class="vertical-line">|</span>&nbsp;', $typeNames);

        return <<<EOL
        <section>
            <div class="line">
                <span class="keyword" id="graphql-type-{$union->getName()}" title="{$normalizedDescription}">union&nbsp;</span>
                <span class="typename">{$union->getName()}&nbsp;<span class="equals">=</span>&nbsp;{$types}</span>
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
                <span class="keyword" id="graphql-type-{$input->getName()}" title="{$normalizedDescription}">input&nbsp;</span>
                <span class="typename">{$input->getName()}</span>
                <span class="usage">{$this->printDirectiveUsages($input->getDirectiveUsages())}</span>
                <span class="bracket-curly">&nbsp;{</span>
            </div>
            <div class="line offset-1">
                {$this->printItems($input->getArguments())}
            </div>
            <div class="line">
                <span class="bracket-curly">}</span>
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
                <span class="keyword" id="graphql-type-{$scalar->getName()}" title="{$normalizedDescription}">scalar&nbsp;</span>
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
                <span class="keyword" id="graphql-type-{$enum->getName()}" title="{$normalizedDescription}">enum&nbsp;</span>
                <span class="typename">{$enum->getName()}</span>
                <span class="bracket-curly">&nbsp;{</span>
            </div>
            <div class="line offset-1">
                {$this->printItems($enum->getItems())}
            </div>
            <div class="line">
                <span class="bracket-curly">}</span>
            </div>
        </section>
        EOL;
    }

    public function visitDirective(\Graphpinator\Directive\Directive $directive) : string
    {
        $normalizedDescription = static::normalizeString($directive->getDescription());
        $directiveAdditional = $this->printArguments($directive);

        if ($directive->isRepeatable()) {
            $directiveAdditional .= '<span class="keyword">&nbsp;repeatable</span>';
        }

        $directiveAdditional .= '<span class="keyword">&nbsp;on&nbsp;</span>';
        $directiveAdditional .= '<span class="location">' . \implode('&nbsp;|&nbsp;', $directive->getLocations()) . '</span>';

        return <<<EOL
        <section>
            <div class="line">
                <span class="keyword" id="graphql-type-{$directive->getName()}" title="{$normalizedDescription}">directive&nbsp;</span>
                <span class="typename">@{$directive->getName()}</span>
                {$directiveAdditional}
            </div>
        </section>
        EOL;
    }

    public function visitField(\Graphpinator\Field\Field $field) : string
    {
        $normalizedDescription = static::normalizeString($field->getDescription());
        $name = static::printName($field->getType()->printName());

        return <<<EOL
        <div class="line offset-1">
            <span class="fieldname">{$field->getName()}</span>
            <div class="arguments">{$this->printArguments($field)}</div>
            <span class="colon">:&nbsp;</span>
            <a class="fieldtype" href="#graphql-type-{$field->getType()->getShapingType()->getNamedType()->printName()}" title="{$normalizedDescription}">{$name}</a>
            {$this->printDirectiveUsages($field->getDirectiveUsages())}
        </div>
        EOL;
    }

    public function visitArgument(\Graphpinator\Argument\Argument $argument) : string
    {
        $defaultValue = '';
        $name = $this->printName($argument->getType()->printName());

        if ($argument->getDefaultValue() instanceof \Graphpinator\Value\ArgumentValue) {
            $defaultValue .= '<span class="equals">&nbsp;=&nbsp;</span>';
            $defaultValue .= '<span class="argument-value">' . $this->printValue($argument->getDefaultValue()->getValue()) . '</span>';
        }

        return <<<EOL
            <span class="argument-name">{$argument->getName()}</span>
            <span class="colon">:&nbsp;</span>
            <a class="argument-type" href="#graphql-type-{$argument->getType()->getShapingType()->getNamedType()->printName()}">{$name}</a>
            {$defaultValue}
            {$this->printDirectiveUsages($argument->getDirectiveUsages())}
        EOL;
    }

    public function visitDirectiveUsage(\Graphpinator\DirectiveUsage\DirectiveUsage $directiveUsage) : string
    {
        $schema = '<span class="typename">&nbsp;@' . $directiveUsage->getDirective()->getName() . '</span>';
        $printableArguments = [];

        foreach ($directiveUsage->getArgumentValues() as $argument) {
            // do not print default value
            if ($argument->getValue()->getRawValue() === $argument->getArgument()->getDefaultValue()?->getValue()->getRawValue()) {
                continue;
            }

            $printableArgument = '<span class="directive-usage-name">' . $argument->getArgument()->getName() . '</span>';
            $printableArgument .= '<span class="colon">:&nbsp;</span>';
            $printableArgument .= '<span class="directive-usage-value">' . static::printName($argument->getValue()->printValue()) . '</span>';

            $printableArguments[] =  $printableArgument;
        }

        if (\count($printableArguments)) {
            $schema .= '<span class="bracket-round">(</span>' . \implode('<span class="comma">,</span>&nbsp;', $printableArguments) . '<span class="bracket-round">)</span>';
        }

        return $schema;
    }

    public function visitEnumItem(\Graphpinator\EnumItem\EnumItem $enumItem) : string
    {
        $normalizedDescription = static::normalizeString($enumItem->getDescription());

        return <<<EOL
            <span class="enumitem line" title="{$normalizedDescription}">{$enumItem->getName()}{$this->printDirectiveUsages($enumItem->getDirectiveUsages())}</span>
        EOL;
    }

    public function glue(array $entries) : string
    {
        return \preg_replace('/\>\s+\</', '><', \implode('', $entries));
    }

    private function printImplements(\Graphpinator\Type\InterfaceSet $implements) : string
    {
        if (\count($implements) === 0) {
            return '';
        }

        return '&nbsp;implements&nbsp;' . \implode('&nbsp;&&nbsp;', self::recursiveGetInterfaces($implements));
    }

    /**
     * @param \Graphpinator\Type\InterfaceSet $implements
     * @return array<string>
     */
    private static function recursiveGetInterfaces(\Graphpinator\Type\InterfaceSet $implements) : array
    {
        $return = [];

        foreach ($implements as $interface) {
            $return += self::recursiveGetInterfaces($interface->getInterfaces());
            $return[] = '<a class="typename" href="#graphql-type-' . $interface->getName() . '">' . $interface->getName() . '</a>';
        }

        return $return;
    }

    private function printDirectiveUsages(\Graphpinator\DirectiveUsage\DirectiveUsageSet $set) : string
    {
        $return = '';

        foreach ($set as $directiveUsage) {
            $return .= $directiveUsage->accept($this);
        }

        return $return;
    }

    private function printItems(
        \Graphpinator\Field\FieldSet|\Graphpinator\Argument\ArgumentSet|\Graphpinator\EnumItem\EnumItemSet $set,
    ) : string
    {
        $result = '';

        foreach ($set as $item) {
            $result .= '<div class="item">' . $item->accept($this) . '</div>';
        }

        return $result;
    }

    private function printLeafValue(\Graphpinator\Value\InputedValue $value) : string
    {
        $className = '';

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
            $openingChar = '<span class="bracket-curly">{</span>';
            $closingChar = '<span class="bracket-curly">}</span>';

            foreach ($value as $key => $innerValue) {
                \assert($innerValue instanceof \Graphpinator\Value\ArgumentValue);

                $component[] = '<span class="value-name">' . $key . '</span><span class="colon">:</span>' . $this->printValue($innerValue->getValue());
            }
        } elseif ($value instanceof \Graphpinator\Value\ListInputedValue) {
            $openingChar = '<span class="bracket-square">[</span>';
            $closingChar = '<span class="bracket-square">]</span>';

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

    private function printArguments(\Graphpinator\Directive\Directive|\Graphpinator\Field\Field $component) : string
    {
        $toReturn = '';

        if ($component->getArguments()->count() > 0) {
            $toReturn .= '<span class="bracket-round">(</span>';
            $toReturn .= '<div class="line offset-1">' . $this->printItems($component->getArguments()) . '</div>';
            $toReturn .= '<span class="bracket-round">)</span>';
        }

        return $toReturn;
    }

    private static function normalizeString(?string $input) : string
    {
        return \is_string($input)
            ? \htmlspecialchars($input)
            : '';
    }

    private static function printName(string $input) : string
    {
        $input = \str_replace('!', '<span class="exclamation-mark">!</span>', $input);
        $input = \str_replace('[', '<span class="bracket-square">[</span>', $input);
        $input = \str_replace(']', '<span class="bracket-square">]</span>', $input);

        return $input;
    }
}
