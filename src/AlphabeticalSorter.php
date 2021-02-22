<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

final class AlphabeticalSorter implements \Graphpinator\Printer\Sorter
{
    /**
     * @param array<\Graphpinator\Type\Contract\NamedDefinition> $types
     * @param array<\Graphpinator\Directive\Contract\Definition> $directives
     * @return array<\Graphpinator\Type\Contract\NamedDefinition|\Graphpinator\Directive\Contract\Definition>
     */
    public function sort(array $types, array $directives) : array
    {
        $entities = $types + $directives;
        \ksort($entities);

        return $entities;
    }
}
