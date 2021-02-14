<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

interface Sorter
{
    public function sort(array $types, array $directives) : array;
}
