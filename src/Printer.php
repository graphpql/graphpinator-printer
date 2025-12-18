<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

use Graphpinator\Typesystem\Schema;

final class Printer
{
    private PrintComponentVisitor $visitor;
    private Sorter $sorter;

    public function __construct(
        ?PrintComponentVisitor $visitor = null,
        ?Sorter $sorter = null,
    )
    {
        $this->visitor = $visitor
            ?? new TextVisitor();
        $this->sorter = $sorter
            ?? new AlphabeticalSorter();
    }

    public function printSchema(Schema $schema) : string
    {
        $entries = [$schema->accept($this->visitor)];
        $printables = $this->sorter->sort($schema->getContainer()->getTypes(), $schema->getContainer()->getDirectives());

        foreach ($printables as $printable) {
            $entries[] = $printable->accept($this->visitor);
        }

        return $this->visitor->glue($entries);
    }
}
