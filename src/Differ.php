<?php

namespace Differ\Differ;

use function Differ\Parsers\getContentFromFile;

function valueAsString($value)
{
    if (is_bool($value)) {
        if ($value === true) {
            return "true";
        } else {
            return "false";
        }
    }

    if ($value === null) {
        return "null";
    }

    return $value;
}

function createIntendant(int $depth, int $mode): string
{
    $intendants = ["    ", '  - ', '  + '];

    switch ($mode) {
        case 0:
            return str_repeat($intendants[0], $depth) . $intendants[0];
        break;
        case 1:
            return str_repeat($intendants[0], $depth) . $intendants[1];
        case 2:
            return str_repeat($intendants[0], $depth) . $intendants[2];
    }
}

function getArrayValues(array $array, int $depth, string $outputString = ""): string
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $outputString = $outputString . createIntendant($depth, 0) . $key .
            ": {\n" . getArrayValues($value, $depth + 1) . "\n";
        } else {
            $outputString = $outputString . createIntendant($depth, 0) . $key .
            ": " . valueAsString($value) . "\n";
        }
    }

    $outputString = $outputString . createIntendant($depth - 1, 0) . "}";

    return $outputString;
}

function iter($array1, $array2, $depth, $result = "")
{

    $result = $result . "{\n";

    $mergeKeys = array_unique(array_merge(array_keys($array1), array_keys($array2)));
    asort($mergeKeys);

    foreach ($mergeKeys as $mergeKey) {
        // Key exists in array1 and array2
        if (
            array_key_exists($mergeKey, $array1)
            && array_key_exists($mergeKey, $array2)
        ) {
            //Value is array in $array1 and $array2
            if (is_array($array1[$mergeKey]) && is_array($array2[$mergeKey])) {
                $result = $result . createIntendant($depth, 0) . $mergeKey .
                ": " . iter($array1[$mergeKey], $array2[$mergeKey], $depth + 1);
            }

            //Value is NOT array in $array1 and NOT array in $array2
            if (!is_array($array1[$mergeKey]) && !is_array($array2[$mergeKey])) {
                if ($array1[$mergeKey] == $array2[$mergeKey]) {
                    $result = $result . createIntendant($depth, 0) . $mergeKey .
                    ": " . valueAsString($array1[$mergeKey]) . "\n";
                } else {
                    $result = $result . createIntendant($depth, 1) . $mergeKey .
                    ": " . valueAsString($array1[$mergeKey]) . "\n";
                    $result = $result . createIntendant($depth, 2) . $mergeKey .
                    ": " . valueAsString($array2[$mergeKey]) . "\n";
                }
            }

            //Value is array in $array1 and NOT array in $array2
            if (is_array($array1[$mergeKey]) && !is_array($array2[$mergeKey])) {
                $result = $result . createIntendant($depth, 1) . $mergeKey .
                ": {\n" . getArrayValues($array1[$mergeKey], $depth + 1) . "\n";
                $result = $result . createIntendant($depth, 2) . $mergeKey .
                ": " . valueAsString($array2[$mergeKey]) . "\n";
            }

            //Value is NOT array in $array1 and array in $array2
            if (!is_array($array1[$mergeKey]) && is_array($array2[$mergeKey])) {
                $result = $result . createIntendant($depth, 1) . $mergeKey .
                ": " . valueAsString($array1[$mergeKey]) . "\n";
                $result = $result . createIntendant($depth, 2) . $mergeKey .
                ": {\n" . getArrayValues($array2[$mergeKey], $depth + 1) . "\n";
            }
        }

        //Key exists in array1 and doesn't exist in array2
        if (
            array_key_exists($mergeKey, $array1)
            && !(array_key_exists($mergeKey, $array2))
        ) {
            if (is_array($array1[$mergeKey])) {
                $result = $result . createIntendant($depth, 1) . $mergeKey .
                ": {\n" . getArrayValues($array1[$mergeKey], $depth + 1) . "\n";
            } else {
                $result = $result . createIntendant($depth, 1) . $mergeKey .
                ": " . valueAsString($array1[$mergeKey]) . "\n";
            }
        }

        //Key doesn't exist in array1 and exists in array2
        if (
            !(array_key_exists($mergeKey, $array1))
            && array_key_exists($mergeKey, $array2)
        ) {
            if (is_array($array2[$mergeKey])) {
                $result = $result . createIntendant($depth, 2) . $mergeKey .
                ": {\n" . getArrayValues($array2[$mergeKey], $depth + 1) . "\n";
            } else {
                $result = $result . createIntendant($depth, 2) . $mergeKey .
                ": " . valueAsString($array2[$mergeKey]) . "\n";
            }
        }
    }

    if ($depth == 0) {
        $result = $result . "}";
    } else {
        $result = $result . createIntendant($depth - 1, 0) . "}\n";
    }

    return $result;
}

function genDiff($pathFile1, $pathFile2)
{
    $array1 = getContentFromFile($pathFile1);
    $array2 = getContentFromFile($pathFile2);

    return iter($array1, $array2, 0);
}
