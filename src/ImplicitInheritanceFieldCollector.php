<?php

declare(strict_types = 1);

namespace Graphpinator\Printer;

use \Graphpinator\Typesystem\Contract\InterfaceImplementor;
use \Graphpinator\Typesystem\Contract\Type;
use \Graphpinator\Typesystem\Argument\Argument;
use \Graphpinator\Typesystem\Argument\ArgumentSet;
use \Graphpinator\Typesystem\Field\Field;
use \Graphpinator\Typesystem\Field\FieldSet;
use \Graphpinator\Typesystem\DirectiveUsage\DirectiveUsage;
use \Graphpinator\Typesystem\DirectiveUsage\DirectiveUsageSet;

final class ImplicitInheritanceFieldCollector implements FieldCollector
{
    public function collect(InterfaceImplementor $interfaceImplementor) : FieldSet
    {
        $parentInterfaces = $interfaceImplementor->getInterfaces();

        if (\count($parentInterfaces) === 0) {
            $interfaceImplementor->getFields();
        }

        $fields = clone $interfaceImplementor->getFields();

        foreach ($parentInterfaces as $interface) {
            foreach ($interface->getFields() as $parentField) {
                \assert($fields->offsetExists($parentField->getName()));

                if (self::fieldsAreEqual($parentField, $fields->offsetGet($parentField->getName()))) {
                    $fields->offsetUnset($parentField->getName());
                }
            }
        }

        return $fields;
    }

    /**
     * Fields must have the same properties in order to be implicitly inherited.
     * Checked properties are: description, type, arguments, directiveUsages.
     */
    private static function fieldsAreEqual(Field $fieldA, Field $fieldB) : bool
    {
        return $fieldA->getDescription() === $fieldB->getDescription()
            && self::typeIsEqual($fieldA->getType(), $fieldB->getType())
            && self::argumentsAreEqual($fieldA->getArguments(), $fieldB->getArguments())
            && self::directiveUsagesAreEqual($fieldA->getDirectiveUsages(), $fieldB->getDirectiveUsages());
    }

    private static function typeIsEqual(Type $typeA, Type $typeB) : bool
    {
        return $typeA->isInstanceOf($typeB) && $typeB->isInstanceOf($typeA);
    }

    private static function argumentsAreEqual(ArgumentSet $setA, ArgumentSet $setB) : bool
    {
        if (\count($setA) !== \count($setB)) {
            return false;
        }

        foreach ($setA as $argumentA) {
            \assert($setB->offsetExists($argumentA->getName()));

            if (self::argumentIsEqual($argumentA, $setB->offsetGet($argumentA->getName()))) {
                continue;
            }

            return false;
        }

        return true;
    }

    private static function argumentIsEqual(Argument $argumentA, Argument $argumentB) : bool
    {
        $defaultA = $argumentA->getDefaultValue();
        $defaultB = $argumentB->getDefaultValue();

        return $argumentA->getDescription() === $argumentB->getDescription()
            && self::typeIsEqual($argumentA->getType(), $argumentB->getType())
            && (($defaultA === null && $defaultB === null) || ($defaultA && $defaultB && $defaultA->getValue()->isSame($defaultB->getValue())))
            && self::directiveUsagesAreEqual($argumentA->getDirectiveUsages(), $argumentB->getDirectiveUsages());
    }

    private static function directiveUsagesAreEqual(DirectiveUsageSet $setA, DirectiveUsageSet $setB) : bool
    {
        if (\count($setA) !== \count($setB)) {
            return false;
        }

        foreach ($setA as $index => $directiveUsageA) {
            if (self::directiveUsageIsEqual($directiveUsageA, $setB->offsetGet($index))) {
                continue;
            }

            return false;
        }

        return true;
    }

    private static function directiveUsageIsEqual(DirectiveUsage $directiveUsageA, DirectiveUsage $directiveUsageB) : bool
    {
        return $directiveUsageA->getDirective() === $directiveUsageB->getDirective()
            && $directiveUsageA->getArgumentValues()->isSame($directiveUsageB->getArgumentValues());
    }
}
