<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

final class AlphabeticalSorter implements \Graphpinator\Printer\Sorter
{
    /**
     * @param array<\Graphpinator\Typesystem\Contract\NamedType> $types
     * @param array<\Graphpinator\Typesystem\Contract\Directive> $directives
     * @return array<\Graphpinator\Typesystem\Contract\NamedType|\Graphpinator\Typesystem\Contract\Directive>
     */
    public function sort(array $types, array $directives) : array
    {
        $entities = $types + $directives;
        \ksort($entities);

        return $entities;
    }
}
