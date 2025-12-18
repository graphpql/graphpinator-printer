<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

use Graphpinator\Typesystem\Contract\InterfaceImplementor;
use Graphpinator\Typesystem\Field\FieldSet;

interface FieldCollector
{
    public function collect(InterfaceImplementor $interfaceImplementor) : FieldSet;
}
