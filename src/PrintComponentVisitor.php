<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

use Graphpinator\Typesystem\Contract\ComponentVisitor;

/**
 * @extends ComponentVisitor<string>
 */
interface PrintComponentVisitor extends ComponentVisitor
{
    /**
     * @param array<string> $entries
     */
    public function glue(array $entries) : string;
}
