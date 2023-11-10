<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

final class Printer
{
    private \Graphpinator\Printer\PrintComponentVisitor $visitor;
    private \Graphpinator\Printer\Sorter $sorter;

    public function __construct(
        ?\Graphpinator\Printer\PrintComponentVisitor $visitor = null,
        ?\Graphpinator\Printer\Sorter $sorter = null,
    )
    {
        $this->visitor = $visitor
            ?? new TextVisitor();
        $this->sorter = $sorter
            ?? new AlphabeticalSorter();
    }

    public function printSchema(\Graphpinator\Typesystem\Schema $schema) : string
    {
        $entries = [$schema->accept($this->visitor)];
        $printables = $this->sorter->sort($schema->getContainer()->getTypes(), $schema->getContainer()->getDirectives());

        foreach ($printables as $printable) {
            $entries[] = $printable->accept($this->visitor);
        }

        return $this->visitor->glue($entries);
    }
}
