<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

use Graphpinator\Typesystem\Contract\Directive;
use Graphpinator\Typesystem\Contract\NamedType;
use Graphpinator\Typesystem\Introspection\TypeKind;
use Graphpinator\Typesystem\Visitor\TypeKindVisitor;

class TypeKindSorter implements Sorter
{
    /**
     * @param array<NamedType> $types
     * @param array<Directive> $directives
     * @return array<NamedType|Directive>
     */
    #[\Override]
    public function sort(array $types, array $directives) : array
    {
        $interface = $union = $input = $enum = $scalar = $object = [];

        foreach ($types as $name => $type) {
            match ($type->accept(new TypeKindVisitor())) {
                TypeKind::INTERFACE => $interface[$name] = $type,
                TypeKind::UNION => $union[$name] = $type,
                TypeKind::INPUT_OBJECT => $input[$name] = $type,
                TypeKind::ENUM => $enum[$name] = $type,
                TypeKind::SCALAR => $scalar[$name] = $type,
                TypeKind::OBJECT => $object[$name] = $type,
                default => null,
            };
        }

        \ksort($interface);
        \ksort($union);
        \ksort($input);
        \ksort($enum);
        \ksort($scalar);
        \ksort($object);
        \ksort($directives);

        return \array_merge($interface, $object, $union, $input, $scalar, $enum, $directives);
    }
}
