<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

final class HtmlVisitor implements PrintComponentVisitor
{
    private const LINK_TEXTS = ['Q', 'M', 'S'];
    private const LINK_TITLES = ['Go to query root type', 'Go to mutation root type', 'Go to subscription root type'];

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
        $query = self::generateRootTypeLink($schema->getQuery(), 'query');
        $mutation = $schema->getMutation() instanceof \Graphpinator\Typesystem\Type
            ? self::generateRootTypeLink($schema->getMutation(), 'mutation')
            : '';
        $subscription = $schema->getSubscription() instanceof \Graphpinator\Typesystem\Type
            ? self::generateRootTypeLink($schema->getSubscription(), 'subscription')
            : '';

        return <<<EOL
        <section id="graphql-schema">
            {$this->printDescription($schema->getDescription())}
            <div class="line">
                <a href="#graphql-schema" class="self-link">
                    <span class="keyword">schema</span>
                </a>
                {$this->printDirectiveUsages($schema->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div class="offset">
                {$query}
                {$mutation}
                {$subscription}
            </div>
            <div class="line">
                <span class="bracket-curly">}</span>
            </div>
        </section>
        EOL;
    }

    private static function generateRootTypeLink(\Graphpinator\Typesystem\Type $type, string $rootType) : string
    {
        $link = self::printTypeLink($type);

        return <<<EOL
        <div class="line">
                    <span class="field-name">{$rootType}</span>
                    <span class="colon">:</span>&nbsp;<span class="field-type">{$link}</span>
                </div>
        EOL;
    }

    public function visitType(\Graphpinator\Typesystem\Type $type) : string
    {
        return <<<EOL
        <section id="graphql-type-{$type->getName()}">
            {$this->printDescription($type->getDescription())}
            <div class="line">
                <a href="#graphql-type-{$type->getName()}" class="self-link">
                    <span class="keyword">type</span>&nbsp;
                    <span class="typename">{$type->getName()}</span>
                </a>
                {$this->printImplements($type->getInterfaces())}
                {$this->printDirectiveUsages($type->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div class="offset">
                {$this->printItems($this->fieldCollector->collect($type))}
            </div>
            <div class="line">
                <span class="bracket-curly">}</span>
            </div>
        </section>
        EOL;
    }

    public function visitInterface(\Graphpinator\Typesystem\InterfaceType $interface) : string
    {
        return <<<EOL
        <section id="graphql-type-{$interface->getName()}">
            {$this->printDescription($interface->getDescription())}
            <div class="line">
                <a href="#graphql-type-{$interface->getName()}" class="self-link">
                    <span class="keyword">interface</span>&nbsp;
                    <span class="typename">{$interface->getName()}</span>
                </a>
                {$this->printImplements($interface->getInterfaces())}
                {$this->printDirectiveUsages($interface->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div class="offset">
                {$this->printItems($this->fieldCollector->collect($interface))}
            </div>
            <div class="line">
                <span class="bracket-curly">}</span>
            </div>
        </section>
        EOL;
    }

    public function visitUnion(\Graphpinator\Typesystem\UnionType $union) : string
    {
        $typeNames = [];

        foreach ($union->getTypes() as $type) {
            $typeNames[] = '<span class="union-type">' . self::printTypeLink($type) . '</span>';
        }

        $types = \implode('&nbsp;<span class="vertical-line">|</span>&nbsp;', $typeNames);

        return <<<EOL
        <section id="graphql-type-{$union->getName()}">
            {$this->printDescription($union->getDescription())}
            <div class="line">
                <a href="#graphql-type-{$union->getName()}" class="self-link">
                    <span class="keyword">union</span>&nbsp;
                    <span class="typename">{$union->getName()}</span>
                </a>
                {$this->printDirectiveUsages($union->getDirectiveUsages())}&nbsp;
                <span class="equals">=</span>&nbsp;{$types}
            </div>
        </section>
        EOL;
    }

    public function visitInput(\Graphpinator\Typesystem\InputType $input) : string
    {
        return <<<EOL
        <section id="graphql-type-{$input->getName()}">
            {$this->printDescription($input->getDescription())}
            <div class="line">
                <a href="#graphql-type-{$input->getName()}" class="self-link">
                    <span class="keyword">input</span>&nbsp;
                    <span class="typename">{$input->getName()}</span>
                </a>
                {$this->printDirectiveUsages($input->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div class="offset">
                {$this->printItems($input->getArguments())}
            </div>
            <div class="line">
                <span class="bracket-curly">}</span>
            </div>
        </section>
        EOL;
    }

    public function visitScalar(\Graphpinator\Typesystem\ScalarType $scalar) : string
    {
        return <<<EOL
        <section id="graphql-type-{$scalar->getName()}">
            {$this->printDescription($scalar->getDescription())}
            <div class="line">
                <a href="#graphql-type-{$scalar->getName()}" class="self-link">
                    <span class="keyword">scalar</span>&nbsp;
                    <span class="typename">{$scalar->getName()}</span>
                </a>
                {$this->printDirectiveUsages($scalar->getDirectiveUsages())}
            </div>
        </section>
        EOL;
    }

    public function visitEnum(\Graphpinator\Typesystem\EnumType $enum) : string
    {
        return <<<EOL
        <section id="graphql-type-{$enum->getName()}">
            {$this->printDescription($enum->getDescription())}
            <div class="line">
                <a href="#graphql-type-{$enum->getName()}" class="self-link">
                    <span class="keyword">enum</span>&nbsp;
                    <span class="typename">{$enum->getName()}</span>
                </a>
                {$this->printDirectiveUsages($enum->getDirectiveUsages())}&nbsp;
                <span class="bracket-curly">{</span>
            </div>
            <div class="offset">
                {$this->printItems($enum->getItems())}
            </div>
            <div class="line">
                <span class="bracket-curly">}</span>
            </div>
        </section>
        EOL;
    }

    public function visitDirective(\Graphpinator\Typesystem\Directive $directive) : string
    {
        $repeatable = $directive->isRepeatable()
            ? '&nbsp;<span class="keyword">repeatable</span>'
            : '';
        $locations = \implode(
            '</span>&nbsp;<span class="vertical-line">|</span>&nbsp;<span class="enum-literal">',
            \array_column($directive->getLocations(), 'value'),
        );

        return <<<EOL
        <section id="graphql-directive-{$directive->getName()}">
            {$this->printDescription($directive->getDescription())}
            <div class="line">
                <a href="#graphql-directive-{$directive->getName()}" class="self-link">
                    <span class="keyword">directive</span>&nbsp;
                    <span class="typename">@{$directive->getName()}</span>
                </a>
                {$this->printArguments($directive)}
                {$repeatable}&nbsp;<span class="keyword">on</span>&nbsp;<span class="enum-literal">{$locations}</span>
            </div>
        </section>
        EOL;
    }

    public function visitField(\Graphpinator\Typesystem\Field\Field $field) : string
    {
        $link = self::printTypeLink($field->getType());

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

    public function visitArgument(\Graphpinator\Typesystem\Argument\Argument $argument) : string
    {
        $defaultValue = '';
        $link = '<span class="argument-type">' . self::printTypeLink($argument->getType()) . '</span>';

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

    public function visitDirectiveUsage(\Graphpinator\Typesystem\DirectiveUsage\DirectiveUsage $directiveUsage) : string
    {
        $schema = '&nbsp;<span class="typename">' . self::printDirectiveLink($directiveUsage) . '</span>';
        $printableArguments = [];

        foreach ($directiveUsage->getArgumentValues() as $argument) {
            // do not print default value
            if ($argument->getValue()->getRawValue() === $argument->getArgument()->getDefaultValue()?->getValue()->getRawValue()) {
                continue;
            }

            $printableArgument = '<span class="argument-name">' . $argument->getArgument()->getName() . '</span>';
            $printableArgument .= '<span class="colon">:</span>&nbsp;';
            $printableArgument .= '<span class="argument-value">' . $this->printValue($argument->getValue()) . '</span>';

            $printableArguments[] = $printableArgument;
        }

        if (\count($printableArguments)) {
            $schema .= '<span class="bracket-round">(</span>'
                . \implode('<span class="comma">,</span>&nbsp;', $printableArguments)
                . '<span class="bracket-round">)</span>';
        }

        return $schema;
    }

    public function visitEnumItem(\Graphpinator\Typesystem\EnumItem\EnumItem $enumItem) : string
    {
        return $this->printItemDescription($enumItem->getDescription()) . '<div class="line enum-item">' . $enumItem->getName()
            . $this->printDirectiveUsages($enumItem->getDirectiveUsages()) . '</div>';
    }

    public function glue(array $entries) : string
    {
        $html = '<div class="graphpinator-schema">'
            . self::printFloatingButtons($entries[0])
            . '<div class="code">'
            . \implode(self::emptyLine(), $entries)
            . '</div></div>';
        // Replace whitespace between tags
        $html = \preg_replace('/>\s+</', '><', $html);
        // Replace whitespace between tags but leave out &nbsp;
        $html = \preg_replace('/>((\s+(&nbsp;){1}\s*)|(\s*(&nbsp;){1}\s+))</', '>&nbsp;<', $html);

        // Replace empty line div with empty line containing &nbsp; (empty divs are ignored by browsers)
        return \str_replace('<div class="line"></div>', self::emptyLine(), $html);
    }

    /**
     * @return array<string>
     */
    private static function recursiveGetInterfaces(\Graphpinator\Typesystem\InterfaceSet $implements) : array
    {
        $return = [];

        foreach ($implements as $interface) {
            $return += self::recursiveGetInterfaces($interface->getInterfaces());
            $return[] = self::printTypeLink($interface);
        }

        return $return;
    }

    private static function printTypeLink(\Graphpinator\Typesystem\Contract\Type $type) : string
    {
        return match ($type::class) {
            \Graphpinator\Typesystem\NotNullType::class =>
                self::printTypeLink($type->getInnerType()) .
                '<span class="exclamation-mark">!</span>',
            \Graphpinator\Typesystem\ListType::class =>
                '<span class="bracket-square">[</span>' .
                self::printTypeLink($type->getInnerType()) .
                '<span class="bracket-square">]</span>',
            default => self::printNamedTypeLink($type),
        };
    }

    private static function printNamedTypeLink(\Graphpinator\Typesystem\Contract\NamedType $type) : string
    {
        $href = \str_starts_with($type->getNamedType()::class, 'Graphpinator\Typesystem\Spec')
            ? ''
            : 'href="#graphql-type-' . $type->getNamedType()->getName() . '"';
        $description = self::normalizeString($type->getNamedType()->getDescription());

        return <<<EOL
        <a class="typename" {$href} title="{$description}">{$type->printName()}</a>
        EOL;
    }

    private static function printDirectiveLink(\Graphpinator\Typesystem\DirectiveUsage\DirectiveUsage $directiveUsage) : string
    {
        $href = \str_starts_with($directiveUsage->getDirective()::class, 'Graphpinator\Typesystem\Spec')
            ? ''
            : 'href="#graphql-directive-' . $directiveUsage->getDirective()->getName() . '"';
        $description = self::normalizeString($directiveUsage->getDirective()->getDescription());

        return <<<EOL
        <a class="typename" {$href} title="{$description}">@{$directiveUsage->getDirective()->getName()}</a>
        EOL;
    }

    private static function printFloatingButtons(string $schemaString) : string
    {
        $result = '';
        $matches = [];
        \preg_match_all('/(<a .+?<\/a>)/', $schemaString, $matches);

        foreach ($matches[0] as $index => $match) {
            $match = \preg_replace('/(?<=>).*?(?=<)/', self::LINK_TEXTS[$index], $match);
            $match = \preg_replace('/(?<=title=").*?(?=")/', self::LINK_TITLES[$index], $match);
            $match = \str_replace('class="typename"', 'class="floating-button"', $match);
            $result .= $match;
        }

        return <<<EOL
        <div class="floating-container">
            <a class="floating-button" href="#graphql-schema" title="Go to top">&uarr;</a>
            {$result}
        </div>
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

    private function printImplements(\Graphpinator\Typesystem\InterfaceSet $implements) : string
    {
        if (\count($implements) === 0) {
            return '';
        }

        return '&nbsp;<span class="keyword">implements</span>&nbsp;'
            . \implode('&nbsp;<span class="ampersand">&</span>&nbsp;', self::recursiveGetInterfaces($implements));
    }

    private function printDirectiveUsages(\Graphpinator\Typesystem\DirectiveUsage\DirectiveUsageSet $set) : string
    {
        $return = '';

        foreach ($set as $directiveUsage) {
            $return .= $directiveUsage->accept($this);
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
                $result .= self::emptyLine();
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

                $component[] = '<span class="value-name">' . $key . '</span><span class="colon">:</span>'
                    . $this->printValue($innerValue->getValue());
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

    private function printArguments(\Graphpinator\Typesystem\Directive|\Graphpinator\Typesystem\Field\Field $component) : string
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

        $lines = \explode(\PHP_EOL, \htmlspecialchars($description));
        $printedLines = '';

        foreach ($lines as $line) {
            $line = \rtrim($line);
            $printedLines .= '<div class="line">' . ($line === '' ? '&nbsp;' : $line) . '</div>';
        }

        return <<<EOL
        <div class="description">
            <div class="line">"""</div>
            {$printedLines}
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
}
