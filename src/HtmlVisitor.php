<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

final class HtmlVisitor implements PrintComponentVisitor
{
    public function visitSchema(\Graphpinator\Type\Schema $schema) : string
    {
        $query = '<span class="field-type">' . static::printTypeLink($schema->getQuery()) . '</span>';
        $mutation = $schema->getMutation() instanceof \Graphpinator\Type\Type
            ? '<span class="field-type">' . static::printTypeLink($schema->getMutation()) . '</span>'
            : '<span class="null">null</span>';

        $subscription = $schema->getSubscription() instanceof \Graphpinator\Type\Type
            ? '<span class="field-type">' . static::printTypeLink($schema->getSubscription()) . '</span>'
            : '<span class="null">null</span>';

        return <<<EOL
        <section id="graphql-schema">
            {$this->printDescription($schema->getDescription())}
            <div class="line">
                <span class="keyword">schema</span>&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div class="offset">
                <div class="line">
                    <span class="field-name">query</span>
                    <span class="colon">:</span>&nbsp;
                    {$query}
                </div>
                <div class="line">
                    <span class="field-name">mutation</span>
                    <span class="colon">:</span>&nbsp;
                    {$mutation}
                </div>
                <div class="line">
                    <span class="field-name">subscription</span>
                    <span class="colon">:</span>&nbsp;
                    {$subscription}
                </div>
            </div>
            <div class="line">
                <div class="bracket-curly">}</div>
            </div>
        </section>
        EOL;
    }

    public function visitType(\Graphpinator\Type\Type $type) : string
    {
        return <<<EOL
        <section id="graphql-type-{$type->getName()}">
            {$this->printDescription($type->getDescription())}
            <div class="line">
                <span class="keyword">type</span>&nbsp;
                <span class="typename">{$type->getName()}</span>
                {$this->printImplements($type->getInterfaces())}
                {$this->printDirectiveUsages($type->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div class="offset">
                {$this->printItems($type->getFields())}
            </div>
            <div class="line">
                <div class="bracket-curly">}</div>
            </div>
        </section>
        EOL;
    }

    public function visitInterface(\Graphpinator\Type\InterfaceType $interface) : string
    {
        return <<<EOL
        <section id="graphql-type-{$interface->getName()}">
            {$this->printDescription($interface->getDescription())}
            <div class="line">
                <span class="keyword">interface</span>&nbsp;
                <span class="typename">{$interface->getName()}</span>
                {$this->printImplements($interface->getInterfaces())}
                {$this->printDirectiveUsages($interface->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div class="offset">
                {$this->printItems($interface->getFields())}
            </div>
            <div class="line">
                <div class="bracket-curly">}</div>
            </div>
        </section>
        EOL;
    }

    public function visitUnion(\Graphpinator\Type\UnionType $union) : string
    {
        $typeNames = [];

        foreach ($union->getTypes() as $type) {
            $typeNames[] = '<span class="union-type">' . static::printTypeLink($type) . '</span>';
        }

        $types = \implode('&nbsp;<span class="vertical-line">|</span>&nbsp;', $typeNames);

        return <<<EOL
        <section id="graphql-type-{$union->getName()}">
            {$this->printDescription($union->getDescription())}
            <div class="line">
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
            {$this->printDescription($input->getDescription())}
            <div class="line">
                <span class="keyword">input</span>&nbsp;
                <span class="typename">{$input->getName()}</span>
                {$this->printDirectiveUsages($input->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div class="offset">
                {$this->printItems($input->getArguments())}
            </div>
            <div class="line">
                <div class="bracket-curly">}</div>
            </div>
        </section>
        EOL;
    }

    public function visitScalar(\Graphpinator\Type\ScalarType $scalar) : string
    {
        return <<<EOL
        <section id="graphql-type-{$scalar->getName()}">
            {$this->printDescription($scalar->getDescription())}
            <div class="line">
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
            {$this->printDescription($enum->getDescription())}
            <div class="line">
                <span class="keyword">enum</span>&nbsp;
                <span class="typename">{$enum->getName()}</span>&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div class="offset">
                {$this->printItems($enum->getItems())}
            </div>
            <div class="line">
                <div class="bracket-curly">}</div>
            </div>
        </section>
        EOL;
    }

    public function visitDirective(\Graphpinator\Directive\Directive $directive) : string
    {
        $repeatable = $directive->isRepeatable()
            ? '&nbsp;<span class="keyword">repeatable</span>'
            : '';
        $locations = \implode(
            '</span>&nbsp;<span class="vertical-line">|</span>&nbsp;<span class="enum-literal">',
            $directive->getLocations(),
        );

        return <<<EOL
        <section id="graphql-directive-{$directive->getName()}">
            {$this->printDescription($directive->getDescription())}
            <div class="line">
                <span class="keyword">directive</span>&nbsp;
                <span class="typename">@{$directive->getName()}</span>
                {$this->printArguments($directive)}
                {$repeatable}&nbsp;<span class="keyword">on</span>&nbsp;<span class="enum-literal">{$locations}</span>
            </div>
        </section>
        EOL;
    }

    public function visitField(\Graphpinator\Field\Field $field) : string
    {
        $link = static::printTypeLink($field->getType());

        return <<<EOL
        {$this->printItemDescription($field->getDescription())}
        <div class="line">
            <span class="field-name">{$field->getName()}</span>
            {$this->printArguments($field)}
            <span class="colon">:</span>&nbsp;
            <span class="field-type">{$link}</span>
            {$this->printDirectiveUsages($field->getDirectiveUsages())}
        </div>
        EOL;
    }

    public function visitArgument(\Graphpinator\Argument\Argument $argument) : string
    {
        $defaultValue = '';
        $link = '<span class="argument-type">' . static::printTypeLink($argument->getType()) . '</span>';

        if ($argument->getDefaultValue() instanceof \Graphpinator\Value\ArgumentValue) {
            $defaultValue .= '&nbsp;<span class="equals">=</span>&nbsp;';
            $defaultValue .= '<span class="argument-value">' . $this->printValue($argument->getDefaultValue()->getValue()) . '</span>';
        }

        return <<<EOL
        {$this->printItemDescription($argument->getDescription())}
        <div class="line">
            <span class="argument-name">{$argument->getName()}</span>
            <span class="colon">:</span>&nbsp;
            {$link}
            {$defaultValue}
            {$this->printDirectiveUsages($argument->getDirectiveUsages())}
        </div>
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

            $printableArgument = '<span class="argument-name">' . $argument->getArgument()->getName() . '</span>';
            $printableArgument .= '<span class="colon">:</span>&nbsp;';
            $printableArgument .= '<span class="argument-value">' . $this->printValue($argument->getValue()) . '</span>';

            $printableArguments[] =  $printableArgument;
        }

        if (\count($printableArguments)) {
            $schema .= '<span class="bracket-round">(</span>'
                . \implode('<span class="comma">,</span>&nbsp;', $printableArguments)
                . '<span class="bracket-round">)</span>';
        }

        return $schema;
    }

    public function visitEnumItem(\Graphpinator\EnumItem\EnumItem $enumItem) : string
    {
        return $this->printItemDescription($enumItem->getDescription()) . '<div class="line enum-item">' . $enumItem->getName()
            . $this->printDirectiveUsages($enumItem->getDirectiveUsages()) . '</div>';
    }

    public function glue(array $entries) : string
    {
        $html = '<div class="graphpinator-schema">' . \implode(self::emptyLine(), $entries) . '</div>';

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
            $return[] = static::printTypeLink($interface);
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
                $result .= static::emptyLine();
            }

            $result .= $item->accept($this);
            $previousHasDescription = $currentHasDescription;
            $isFirst = false;
        }

        return $result;
    }

    private function printLeafValue(\Graphpinator\Value\InputedValue $value) : string
    {
        $className = match ($value::class) {
            \Graphpinator\Value\NullInputedValue::class => 'null',
            \Graphpinator\Value\EnumValue::class => 'enum-literal',
            \Graphpinator\Value\ScalarValue::class => match (\get_debug_type($value->getRawValue())) {
                'bool' => $value->getRawValue() ? 'true' : 'false',
                'int' => 'int-literal',
                'float' => 'float-literal',
                'string' => 'string-literal',
            },
        };

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
        if ($component->getArguments()->count() === 0) {
            return '';
        }

        return <<<EOL
            <span class="bracket-round">(</span>
        </div>
        <div class="offset">
            {$this->printItems($component->getArguments())}
        </div>
        <div class="line">
            <span class="bracket-round">)</span>
        EOL;
    }

    private function printDescription(?string $description) : string
    {
        if ($description === null) {
            return '';
        }

        $lines = \str_replace(\PHP_EOL, '</div><div class="line">', \htmlspecialchars($description));

        return <<<EOL
        <div class="description">
            <div class="line">"""</div>
            <div class="line">{$lines}</div>
            <div class="line">"""</div>
        </div>
        EOL;
    }

    private function printItemDescription(?string $description) : string
    {
        if ($description === null) {
            return '';
        }

        if (\str_contains($description, \PHP_EOL)) {
            return $this->printDescription($description);
        }

        // single line description
        return '<div class="description"><div class="line">"' . \htmlspecialchars($description) . '"</div></div>';
    }

    private static function printTypeLink(\Graphpinator\Type\Contract\Definition $type) : string
    {
        return match ($type::class) {
            \Graphpinator\Type\NotNullType::class =>
                self::printTypeLink($type->getInnerType()) .
                '<span class="exclamation-mark">!</span>',
            \Graphpinator\Type\ListType::class =>
                '<span class="bracket-square">[</span>' .
                self::printTypeLink($type->getInnerType()) .
                '<span class="bracket-square">]</span>',
            default => self::printNamedTypeLink($type),
        };
    }

    private static function printNamedTypeLink(\Graphpinator\Type\Contract\NamedDefinition $type) : string
    {
        $href = \str_starts_with($type->getNamedType()::class, 'Graphpinator\Type\Spec')
            ? ''
            : 'href="#graphql-type-' . $type->getNamedType()->getName(). '"';
        $description = self::normalizeString($type->getNamedType()->getDescription());

        return <<<EOL
        <a class="typename"  {$href} title="{$description}">{$type->printName()}</a>
        EOL;
    }

    private static function printDirectiveLink(\Graphpinator\DirectiveUsage\DirectiveUsage $directiveUsage) : string
    {
        $href = \str_starts_with($directiveUsage->getDirective()::class, 'Graphpinator\Directive\Spec')
            ? ''
            : 'href="#graphql-directive-' . $directiveUsage->getDirective()->getName(). '"';
        $description = self::normalizeString($directiveUsage->getDirective()->getDescription());

        return <<<EOL
        <a class="typename" {$href} title="{$description}">@{$directiveUsage->getDirective()->getName()}</a>
        EOL;
    }

    private static function normalizeString(?string $input) : string
    {
        return \is_string($input)
            ? \htmlspecialchars($input)
            : '';
    }

    private static function emptyLine() : string
    {
        return '<div class="line">&nbsp;</div>';
    }
}
