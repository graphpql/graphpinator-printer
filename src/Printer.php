<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

final class Printer
{
    use \Nette\SmartObject;

    private \Graphpinator\Typesystem\EntityVisitor $visitor;
    private \Graphpinator\Printer\Sorter $sorter;

    public function __construct(
        ?\Graphpinator\Typesystem\EntityVisitor $visitor = null,
        ?\Graphpinator\Printer\Sorter $sorter = null,
    )
    {
        $this->visitor = $visitor
            ?? new PrintVisitor();
        $this->sorter = $sorter
            ?? new AlphabeticalSorter();
    }

    public function printSchema(\Graphpinator\Type\Schema $schema) : string
    {
        $entries = [$schema->accept($this->visitor)];
        $printables = $this->sorter->sort($schema->getContainer()->getTypes(), $schema->getContainer()->getDirectives());

        foreach ($printables as $printable) {
            $entries[] = $printable->accept($this->visitor);
        }

        return \implode(\PHP_EOL . \PHP_EOL, $entries);
    }
}
