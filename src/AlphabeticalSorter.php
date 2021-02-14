<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

final class AlphabeticalSorter implements \Graphpinator\Printer\Sorter
{
    public function sort(array $types, array $directives) : array
    {
        $entities = $types + $directives;
        \ksort($entities);

        return $entities;
    }
}
