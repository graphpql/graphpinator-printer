# GraPHPinator Printer [![PHP](https://github.com/infinityloop-dev/graphpinator-printer/workflows/PHP/badge.svg?branch=master)](https://github.com/infinityloop-dev/graphpinator-printer/actions?query=workflow%3APHP) [![codecov](https://codecov.io/gh/infinityloop-dev/graphpinator-printer/branch/master/graph/badge.svg)](https://codecov.io/gh/infinityloop-dev/graphpinator-printer)

:zap::globe_with_meridians::zap: Schema printing visitor for GraPHPinator typesystem.

## Introduction

This library allows printing of GraphQL schema into human-readable format. It supports multiple output formats and ordering options.

## Installation

Install package using composer

```composer require infinityloop-dev/graphpinator-printer```

## How to use

Usage of this library is very simple.

```
$schema; // instance of \Graphpinator\Type\Schema
$printer = new \Graphpinator\Printer\Printer();

echo $printer->printSchema($schema);
```

### Output format

It is possible to implement additional printing mechanisms for various output formats.
This is done by implementing `\Graphpinator\Printer\PrintComponentVisitor` and passing custom instance to `Printer` as first constructor argument.

#### Implementations provided by this library:

- `TextVisitor` (default) - standard mechanism which creates text output
- `HtmlVisitor` - mechanism which creates structured HTML code (there is also a SCSS bundled in the `theme` folder and compiled CSS in `build` folder)

### Output order

It is possible to change the order types/directives in output.
This is done by implementing `\Graphpinator\Printer\Sorter` and passing custom instance to `Printer` as second constructor argument.

#### Implementations provided by this library:

- `AlphabeticalSorter` (default) - sorts types and directives alphabetically
- `TypeKindSorter` - sorts types by their TypeKind (and then alphabetically) - interfaces first, than object types, than unions, ..., directives last
