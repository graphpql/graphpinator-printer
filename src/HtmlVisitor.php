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
            <div>
                <span class="keyword">schema</span>&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div>
                <span class="field-name offset-1">query</span>
                <span class="colon">:</span>&nbsp;
                {$query}
            </div>
            <div>
                <span class="field-name offset-1">mutation</span>
                <span class="colon">:</span>&nbsp;
                {$mutation}
            </div>
            <div>
                <span class="field-name offset-1">subscription</span>
                <span class="colon">:</span>&nbsp;
                {$subscription}
            </div>
            <div class="bracket-curly">}</div>
            {$this->emptyLine()}
        </section>
        EOL;
    }

    public function visitType(\Graphpinator\Type\Type $type) : string
    {
        return <<<EOL
        <section id="graphql-type-{$type->getName()}">
            {$this->printDescription($type->getDescription())}
            <div>
                <span class="keyword">type</span>&nbsp;
                <span class="typename">{$type->getName()}</span>
                {$this->printImplements($type->getInterfaces())}
                {$this->printDirectiveUsages($type->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            {$this->printItems($type->getFields())}
            <div class="bracket-curly">}</div>
            {$this->emptyLine()}
        </section>
        EOL;
    }

    public function visitInterface(\Graphpinator\Type\InterfaceType $interface) : string
    {
        return <<<EOL
        <section id="graphql-type-{$interface->getName()}">
            {$this->printDescription($interface->getDescription())}
            <div>
                <span class="keyword">interface</span>&nbsp;
                <span class="typename">{$interface->getName()}</span>
                {$this->printImplements($interface->getInterfaces())}
                {$this->printDirectiveUsages($interface->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            {$this->printItems($interface->getFields())}
            <div class="bracket-curly">}</div>
            {$this->emptyLine()}
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
            <div>
                <span class="keyword">union</span>&nbsp;
                <span class="typename">{$union->getName()}&nbsp;<span class="equals">=</span>&nbsp;{$types}</span>
            </div>
            {$this->emptyLine()}
        </section>
        EOL;
    }

    public function visitInput(\Graphpinator\Type\InputType $input) : string
    {
        return <<<EOL
        <section id="graphql-type-{$input->getName()}">
            {$this->printDescription($input->getDescription())}
            <div>
                <span class="keyword">input</span>&nbsp;
                <span class="typename">{$input->getName()}</span>
                {$this->printDirectiveUsages($input->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            {$this->printItems($input->getArguments())}
            <div class="bracket-curly">}</div>
            {$this->emptyLine()}
        </section>
        EOL;
    }

    public function visitScalar(\Graphpinator\Type\ScalarType $scalar) : string
    {
        return <<<EOL
        <section id="graphql-type-{$scalar->getName()}">
            {$this->printDescription($scalar->getDescription())}
            <div>
                <span class="keyword">scalar</span>&nbsp;
                <span class="typename">{$scalar->getName()}</span>
            </div>
            {$this->emptyLine()}
        </section>
        EOL;
    }

    public function visitEnum(\Graphpinator\Type\EnumType $enum) : string
    {
        return <<<EOL
        <section id="graphql-type-{$enum->getName()}">
            {$this->printDescription($enum->getDescription())}
            <div>
                <span class="keyword">enum</span>&nbsp;
                <span class="typename">{$enum->getName()}</span>&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            {$this->printItems($enum->getItems())}
            <div class="bracket-curly">}</div>
            {$this->emptyLine()}
        </section>
        EOL;
    }

    public function visitDirective(\Graphpinator\Directive\Directive $directive) : string
    {
        $directiveAdditional = $this->printArguments($directive);

        if ($directive->getArguments()->count() > 0) {
            //Close div right behind first (
            $directiveAdditional = \preg_replace('/\(<\/span>/', '(</span></div>', $directiveAdditional, 1);

            //Wrap last ) element into div
            $directiveAdditional = \preg_replace(
                '~(.*)<span class="bracket-round">\)<\/span>~su',
                '${1}<div><span class="bracket-round">)</span>',
                $directiveAdditional
            );
        }

        if ($directive->isRepeatable()) {
            $directiveAdditional .= '&nbsp;<span class="keyword">repeatable</span>';
        }

        $directiveAdditional .= '&nbsp;<span class="keyword">on</span>&nbsp;';
        $directiveAdditional .= '<span class="enum-literal">'
            . \implode('</span>&nbsp;<span class="vertical-line">|</span>&nbsp;<span class="enum-literal">', $directive->getLocations())
            . '</span></div>';

        return <<<EOL
        <section id="graphql-directive-{$directive->getName()}">
            {$this->printDescription($directive->getDescription())}
            <div>
            <span class="keyword">directive</span>&nbsp;
            <span class="typename">@{$directive->getName()}</span>
            {$directiveAdditional}
            {$this->emptyLine()}
        </section>
        EOL;
    }

    public function visitField(\Graphpinator\Field\Field $field) : string
    {
        $link = '<span class="field-type">' . static::printTypeLink($field->getType()) . '</span>';
        $arguments = $this->printArguments($field);

        if ($field->getArguments()->count() > 0) {
            //Close div right behind first (
            $arguments = \preg_replace('/\(<\/span>/', '(</span></div>', $arguments, 1);

            //Wrap last ) element into div
            $arguments = \preg_replace(
                '~(.*)<span class="bracket-round">\)<\/span>~su',
                '${1}<div class="offset-1"><span class="bracket-round">)</span>',
                $arguments,
            );

            //Replace offset-1 with offset-2 because we are dealing with field's argument
            $arguments = \str_replace('<div class="offset-1 argument">', '<div class="offset-2 argument">', $arguments);
        }

        return <<<EOL
            {$this->printItemDescription($field->getDescription())}
            <div><span class="field-name offset-1">{$field->getName()}</span>
            {$arguments}
            <span class="colon">:</span>&nbsp;
            {$link}
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
            <div class="offset-1 argument">
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
        return $this->printItemDescription($enumItem->getDescription()) . '<div class="enum-item offset-1">' . $enumItem->getName()
            . $this->printDirectiveUsages($enumItem->getDirectiveUsages()) . '</div>';
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

            if (\is_string($rawValue)) {
                $className = 'string-literal';
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
            $toReturn .= $this->printItems($component->getArguments());
            $toReturn .= '<span class="bracket-round">)</span>';
        }

        return $toReturn;
    }

    private function printDescription(?string $description) : string
    {
        if ($description === null) {
            return '';
        }

        return '<div class="description">"""</div><div class="description">' . \htmlspecialchars($description) .  '</div><div class="description">"""</div>';
    }

    private function printItemDescription(?string $description) : string
    {
        if ($description === null) {
            return '';
        }

        if (!\str_contains($description, \PHP_EOL)) {
            return '<div class="description offset-1">"' . $description . '"<br></div>';
        }

        return '<div class="description offset-1">"""</div><div class="description offset-1">'
            . \str_replace(\PHP_EOL, '</div><div class="description offset-1">', $description)
            . '</div><div class="description offset-1">"""</div>';
    }

    private static function normalizeString(?string $input) : string
    {
        return \is_string($input)
            ? \htmlspecialchars($input)
            : '';
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

        return '<a class="typename" ' . $href . ' title="' . self::normalizeString($type->getNamedType()->getDescription()) . '">'
            . $type->printName()
            . '</a>';
    }

    private static function printDirectiveLink(\Graphpinator\DirectiveUsage\DirectiveUsage $directiveUsage) : string
    {
        $href = \str_starts_with($directiveUsage->getDirective()::class, 'Graphpinator\Directive\Spec')
            ? ''
            : 'href="#graphql-directive-' . $directiveUsage->getDirective()->getName(). '"';

        return '<a class="typename" ' . $href . ' title="' . self::normalizeString($directiveUsage->getDirective()->getDescription()) . '">@'
            . $directiveUsage->getDirective()->getName()
            . '</a>';
    }

    private static function emptyLine() : string
    {
        return '<div>&nbsp;</div>';
    }
}
