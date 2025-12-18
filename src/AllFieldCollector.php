<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

use Graphpinator\Typesystem\Contract\InterfaceImplementor;
use Graphpinator\Typesystem\Field\FieldSet;

final class AllFieldCollector implements FieldCollector
{
    #[\Override]
    public function collect(InterfaceImplementor $interfaceImplementor) : FieldSet
    {
        return $interfaceImplementor->getFields();
    }
}
