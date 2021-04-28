<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

final class HtmlVisitor implements PrintComponentVisitor
{
    public function visitSchema(\Graphpinator\Type\Schema $schema) : string
    {
        $query = static::printTypeLink('field-type', $schema->getQuery());
        $mutation = $schema->getMutation() instanceof \Graphpinator\Type\Type
            ? static::printTypeLink('field-type', $schema->getMutation())
            : '<span class="null">null</span>';

        $subscription = $schema->getSubscription() instanceof \Graphpinator\Type\Type
            ? static::printTypeLink('field-type', $schema->getSubscription())
            : '<span class="null">null</span>';

        return <<<EOL
        <section>
            <div class="line">
                {$this->printDescription($schema->getDescription())}
                <span class="keyword">schema</span>&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div class="line offset-1">
                <span class="field-name">query</span>
                <span class="colon">:</span>&nbsp;
                {$query}
            </div>
            <div class="line offset-1">
                <span class="field-name">mutation</span>
                <span class="colon">:</span>&nbsp;
                {$mutation}
            </div>
            <div class="line offset-1">
                <span class="field-name">subscription</span>
                <span class="colon">:</span>&nbsp;
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
        return <<<EOL
        <section id="graphql-type-{$type->getName()}">
            <div class="line">
                {$this->printDescription($type->getDescription())}
                <span class="keyword">type</span>&nbsp;
                <span class="typename">{$type->getName()}</span>
                {$this->printImplements($type->getInterfaces())}
                {$this->printDirectiveUsages($type->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
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
        return <<<EOL
        <section id="graphql-type-{$interface->getName()}">
            <div class="line">
                {$this->printDescription($interface->getDescription())}
                <span class="keyword">interface</span>&nbsp;
                <span class="typename">{$interface->getName()}</span>
                {$this->printImplements($interface->getInterfaces())}
                {$this->printDirectiveUsages($interface->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
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
        $typeNames = [];

        foreach ($union->getTypes() as $type) {
            $typeNames[] = static::printTypeLink('union-type', $type);
        }

        $types = \implode('&nbsp;<span class="vertical-line">|</span>&nbsp;', $typeNames);

        return <<<EOL
        <section id="graphql-type-{$union->getName()}">
            <div class="line">
                {$this->printDescription($union->getDescription())}
                <span class="keyword">union</span>&nbsp;
                <span class="typename">{$union->getName()}&nbsp;<span class="equals">=</span>&nbsp;{$types}</span>
            </div>
        </section>
        EOL;
    }

    public function visitInput(\Graphpinator\Type\InputType $input) : string
    {
        return <<<EOL
        <section id="graphql-type-{$input->getName()}">
            <div class="line">
                {$this->printDescription($input->getDescription())}
                <span class="keyword">input</span>&nbsp;
                <span class="typename">{$input->getName()}</span>
                {$this->printDirectiveUsages($input->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
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
        return <<<EOL
        <section id="graphql-type-{$scalar->getName()}">
            <div class="line">
                {$this->printDescription($scalar->getDescription())}
                <span class="keyword">scalar</span>&nbsp;
                <span class="typename">{$scalar->getName()}</span>
            </div>
        </section>
        EOL;
    }

    public function visitEnum(\Graphpinator\Type\EnumType $enum) : string
    {
        return <<<EOL
        <section id="graphql-type-{$enum->getName()}">
            <div class="line">
                {$this->printDescription($enum->getDescription())}
                <span class="keyword">enum</span>&nbsp;
                <span class="typename">{$enum->getName()}</span>&nbsp;
                <span class="bracket-curly">{</span>
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
        $directiveAdditional = $this->printArguments($directive);

        if ($directive->isRepeatable()) {
            $directiveAdditional .= '&nbsp;<span class="keyword">repeatable</span>';
        }

        $directiveAdditional .= '&nbsp;<span class="keyword">on</span>&nbsp;';
        $directiveAdditional .= '<span class="location">' . \implode('&nbsp;<span class="vertical-line">|</span>&nbsp;', $directive->getLocations()) . '</span>';

        return <<<EOL
        <section>
            <div class="line">
                {$this->printDescription($directive->getDescription())}
                <span class="keyword" id="graphql-type-{$directive->getName()}">directive</span>&nbsp;
                <span class="typename">@{$directive->getName()}</span>
                {$directiveAdditional}
            </div>
        </section>
        EOL;
    }

    public function visitField(\Graphpinator\Field\Field $field) : string
    {
        $link = static::printTypeLink('field-type', $field->getType());

        return <<<EOL
        <div class="line offset-1">
            {$this->printItemDescription($field->getDescription())}
            <span class="field-name">{$field->getName()}</span>
            <div class="arguments">{$this->printArguments($field)}</div>
            <span class="colon">:</span>&nbsp;
            {$link}
            {$this->printDirectiveUsages($field->getDirectiveUsages())}
        </div>
        EOL;
    }

    public function visitArgument(\Graphpinator\Argument\Argument $argument) : string
    {
        $defaultValue = '';
        $link = static::printTypeLink('argument-type', $argument->getType());

        if ($argument->getDefaultValue() instanceof \Graphpinator\Value\ArgumentValue) {
            $defaultValue .= '&nbsp;<span class="equals">=</span>&nbsp;';
            $defaultValue .= '<span class="argument-value">' . $this->printValue($argument->getDefaultValue()->getValue()) . '</span>';
        }

        return <<<EOL
            {$this->printItemDescription($argument->getDescription())}
            <span class="argument-name">{$argument->getName()}</span>
            <span class="colon">:</span>&nbsp;
            {$link}
            {$defaultValue}
            {$this->printDirectiveUsages($argument->getDirectiveUsages())}
        EOL;
    }

    public function visitDirectiveUsage(\Graphpinator\DirectiveUsage\DirectiveUsage $directiveUsage) : string
    {
        $schema = '&nbsp;<span class="typename">' . static::printDirectiveLink($directiveUsage) . '</span>';
        $printableArguments = [];

        foreach ($directiveUsage->getArgumentValues() as $argument) {
            // do not print default value
            if ($argument->getValue()->getRawValue() === $argument->getArgument()->getDefaultValue()?->getValue()->getRawValue()) {
                continue;
            }

            $printableArgument = '<span class="directive-usage-name">' . $argument->getArgument()->getName() . '</span>';
            $printableArgument .= '<span class="colon">:</span>&nbsp;';
            $printableArgument .= '<span class="directive-usage-value">' . static::highlightPunctuation($argument->getValue()->printValue()) . '</span>';

            $printableArguments[] =  $printableArgument;
        }

        if (\count($printableArguments)) {
            $schema .= '<span class="bracket-round">(</span>' . \implode('<span class="comma">,</span>&nbsp;', $printableArguments) . '<span class="bracket-round">)</span>';
        }

        return $schema;
    }

    public function visitEnumItem(\Graphpinator\EnumItem\EnumItem $enumItem) : string
    {
        return $this->printItemDescription($enumItem->getDescription()) . '<span class="enum-item line">' . $enumItem->getName()
            . $this->printDirectiveUsages($enumItem->getDirectiveUsages()) . '</span>';
    }

    public function glue(array $entries) : string
    {
        $html = '<div class="graphpinator-schema">' . \implode('', $entries) . '</div>';

        //Replace whitespace between tags
        $html = \preg_replace('/\>\s+\</', '><', $html);

        //Replace whitespace between tags but leave out &nbsp;
        return \preg_replace('/\>((\s+(&nbsp;){1}\s*)|(\s*(&nbsp;){1}\s+))\</', '>&nbsp;<', $html);
    }

    private function printImplements(\Graphpinator\Type\InterfaceSet $implements) : string
    {
        if (\count($implements) === 0) {
            return '';
        }

        return '&nbsp;<span class="keyword">implements</span>&nbsp;'
            . \implode('&nbsp;<span class="ampersand">&</span>&nbsp;', self::recursiveGetInterfaces($implements));
    }

    /**
     * @return array<string>
     */
    private static function recursiveGetInterfaces(\Graphpinator\Type\InterfaceSet $implements) : array
    {
        $return = [];

        foreach ($implements as $interface) {
            $return += self::recursiveGetInterfaces($interface->getInterfaces());
            $return[] = static::printTypeLink('typename', $interface);
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
        $previousHasDescription = false;
        $isFirst = true;

        foreach ($set as $item) {
            $currentHasDescription = $item->getDescription() !== null;

            if (!$isFirst && ($previousHasDescription || $currentHasDescription)) {
                $result .= '<br>';
            }

            $result .= '<div class="item">' . $item->accept($this) . '</div>';
            $previousHasDescription = $currentHasDescription;
            $isFirst = false;
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
            $className = 'enum-literal';
        }

        if ($value instanceof \Graphpinator\Value\ScalarValue) {
            $rawValue = $value->getRawValue();

            if (\is_bool($rawValue)) {
                $className = $rawValue ? 'true' : 'false';
            }

            if (\is_int($rawValue)) {
                $className = 'int-literal';
            }

            if (\is_float($rawValue)) {
                $className = 'float-literal';
            }
        }

        return '<span class="' . $className . '">' . $value->printValue() . '</span>';
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

        return $openingChar . '<span class="value">' . $components . '</span>' . $closingChar;
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

    private function printDescription(?string $description) : string
    {
        if ($description === null) {
            return '';
        }

        return '<span class="description">"""<br>' . $description .  '<br>"""<br></span>';
    }

    private function printItemDescription(?string $description) : string
    {
        if ($description === null) {
            return '';
        }

        if (!\str_contains($description, \PHP_EOL)) {
            return '<span class="description">"' . $description . '"<br></span>';
        }

        return '<span class="description">"""<br>' . \str_replace(\PHP_EOL, '<br>', $description) . '<br>"""<br></span>';
    }

    private static function normalizeString(?string $input) : string
    {
        return \is_string($input)
            ? \htmlspecialchars($input)
            : '';
    }

    private static function highlightPunctuation(string $input) : string
    {
        $input = \str_replace('!', '<span class="exclamation-mark">!</span>', $input);
        $input = \str_replace('[', '<span class="bracket-square">[</span>', $input);
        $input = \str_replace(']', '<span class="bracket-square">]</span>', $input);

        return $input;
    }

    private static function printTypeLink(string $class, \Graphpinator\Type\Contract\Definition $component) : string
    {
        if (\str_starts_with(\get_class($component->getNamedType()), 'Graphpinator\Type\Spec')) {
            $link = '#';
        } else {
            $link = '#graphql-type-' . $component->getNamedType()->printName();
        }

        return '<a class="' . $class . '" href="' . $link
            . '" title="' . static::normalizeString($component->getNamedType()->getDescription()) . '">' . static::highlightPunctuation($component->printName()). '</a>';
    }

    private static function printDirectiveLink(\Graphpinator\DirectiveUsage\DirectiveUsage $directiveUsage) : string
    {
        if (\str_starts_with(\get_class($directiveUsage->getDirective()), 'Graphpinator\Directive\Spec')) {
            $link = '#';
        } else {
            $link = '#graphql-type-' . $directiveUsage->getDirective()->getName();
        }

        return '<a class="typename" href="' . $link . '">@' . $directiveUsage->getDirective()->getName() . '</a>';
    }
}
