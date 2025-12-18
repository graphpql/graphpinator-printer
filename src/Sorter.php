<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

use Graphpinator\Typesystem\Contract\Directive;
use Graphpinator\Typesystem\Contract\NamedType;

interface Sorter
{
    /**
     * @param array<NamedType> $types
     * @param array<Directive> $directives
     * @return array<NamedType|Directive>
     */
    public function sort(array $types, array $directives) : array;
}
