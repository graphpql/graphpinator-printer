<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

interface PrintComponentVisitor extends \Graphpinator\Typesystem\Contract\ComponentVisitor
{
    /**
     * @param array<string> $entries
     */
    public function glue(array $entries) : string;
}
