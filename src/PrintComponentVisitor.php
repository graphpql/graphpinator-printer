<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

interface PrintComponentVisitor extends \Graphpinator\Typesystem\ComponentVisitor
{
    public function glue(array $entries) : string;
}
