<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

use Graphpinator\Typesystem\Contract\Directive;
use Graphpinator\Typesystem\Contract\NamedType;

final class AlphabeticalSorter implements Sorter
{
    /**
     * @param array<NamedType> $types
     * @param array<Directive> $directives
     * @return array<NamedType|Directive>
     */
    #[\Override]
    public function sort(array $types, array $directives) : array
    {
        $entities = $types + $directives;
        \ksort($entities);

        return $entities;
    }
}
