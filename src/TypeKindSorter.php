<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

class TypeKindSorter implements \Graphpinator\Printer\Sorter
{
    public function sort(array $types, array $directives) : array
    {
        $interface = $union = $input = $enum = $scalar = $object = [];

        foreach ($types as $name => $type) {
            match ($type->getTypeKind()) {
                \Graphpinator\Type\Introspection\TypeKind::INTERFACE => $interface[$name] = $type,
                \Graphpinator\Type\Introspection\TypeKind::UNION => $union[$name] = $type,
                \Graphpinator\Type\Introspection\TypeKind::INPUT_OBJECT => $input[$name] = $type,
                \Graphpinator\Type\Introspection\TypeKind::ENUM => $enum[$name] = $type,
                \Graphpinator\Type\Introspection\TypeKind::SCALAR => $scalar[$name] = $type,
                \Graphpinator\Type\Introspection\TypeKind::OBJECT => $object[$name] = $type,
            };
        }

        \ksort($interface);
        \ksort($union);
        \ksort($input);
        \ksort($enum);
        \ksort($scalar);
        \ksort($object);

        return \array_merge($interface, $object, $union, $input, $scalar, $enum, $directives);
    }
}
