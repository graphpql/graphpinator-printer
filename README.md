# GraPHPinator Printer [![PHP](https://github.com/graphpql/graphpinator-printer/actions/workflows/php.yml/badge.svg)](https://github.com/graphpql/graphpinator-printer/actions/workflows/php.yml) [![codecov](https://codecov.io/gh/infinityloop-dev/graphpinator-printer/branch/master/graph/badge.svg)](https://codecov.io/gh/infinityloop-dev/graphpinator-printer)

:zap::globe_with_meridians::zap: Schema printing visitor for GraPHPinator typesystem.

## Introduction

This library allows printing of the GraphQL schema into human-readable format. It supports multiple output formats and ordering options.

## Installation

Install package using composer

```composer require infinityloop-dev/graphpinator-printer```

## How to use

Usage of this library is very simple.

```php
$schema; // instance of \Graphpinator\Typesystem\Schema
$printer = new \Graphpinator\Printer\Printer();

echo $printer->printSchema($schema);
```

Advanced configiration options (see description below)

```php
$schema; // instance of \Graphpinator\Typesystem\Schema
$printer = new \Graphpinator\Printer\Printer(
    new \Graphpinator\Printer\HtmlVisitor( // different format
        new \Graphpinator\Printer\ImplicitInheritanceFieldCollector(), // enable implicit inheritance
    ),
    new \Graphpinator\Printer\TypeKindSorter(), // different sorter
);

echo $printer->printSchema($schema);
```


### Format

It is possible to implement additional printing mechanisms for various output formats.
This is done by implementing `\Graphpinator\Printer\PrintComponentVisitor` and passing an instance to `Printer` as first constructor argument.

#### Implementations provided by this library:

- `TextVisitor` (default) - standard mechanism which creates text output
- `HtmlVisitor` - mechanism which creates structured HTML code (there is also a SCSS bundled in the `theme` folder and compiled CSS in `build` folder)

### Implicit inheritance

Both formatters support Implicit inheritance RFC - option to exclude fields inherited from parent interface.
In order to enable implicit inheritance, it is needed to pass different `FieldCollector` strategy to `TextVisitor` or `HtmlVisitor`.

#### Strategies provided by this library:

- `AllFieldCollector` (default) - standard strategy to print all fields
- `ImplicitInheritanceFieldCollector` - strategy to leverage Implicit inheritance RFC, inherited fields which remained the same are excluded 

### Order of types

It is possible to change the order of types/directives in output.
This is done by implementing `\Graphpinator\Printer\Sorter` and passing an instance to `Printer` as second constructor argument.

#### Implementations provided by this library:

- `AlphabeticalSorter` (default) - sorts types and directives alphabetically
- `TypeKindSorter` - sorts types by their TypeKind (and then alphabetically) - interfaces first, then object types, then unions, ..., directives last
