<?php

namespace Differ\Differ;

use function Differ\Parsers\getContentFromFile;
use function Differ\Formatters\formatter;

function createArrayDiff(array $array1, array $array2, string $mergeKey): array
{
    $action = null;
    $value = null;
    $newValue = null;

        // Key exists in array1 and array2
    if (
            array_key_exists($mergeKey, $array1)
            && array_key_exists($mergeKey, $array2)
    ) {
        //Value is array in $array1 and $array2
        if (is_array($array1[$mergeKey]) && is_array($array2[$mergeKey])) {
            $action = 'same';
            $value = diff($array1[$mergeKey], $array2[$mergeKey]);
        }

        //Value is array in $array1 and  not array in $array2
        if (is_array($array1[$mergeKey]) && !is_array($array2[$mergeKey])) {
            $action = 'updated';
            $value = diff($array1[$mergeKey], $array1[$mergeKey]);
            $newValue = $array2[$mergeKey];
        }

        //Value is  not array in $array1 and array in $array2
        if (!is_array($array1[$mergeKey]) && is_array($array2[$mergeKey])) {
            $action = 'updated';
            $value = $array1[$mergeKey];
            $newValue = diff($array2[$mergeKey], $array2[$mergeKey]);
            ;
        }
        //Value is not array in $array1 and  not array in $array2
        if (!is_array($array1[$mergeKey]) && !is_array($array2[$mergeKey])) {
            if ($array1[$mergeKey] === $array2[$mergeKey]) {
                $action = 'same';
                $value = $array1[$mergeKey];
            } else {
                $action = 'updated';
                $value = $array1[$mergeKey];
                $newValue = $array2[$mergeKey];
            }
        }
    }

      // Key exists in array1 and doesn't exist in array2
    if (
            array_key_exists($mergeKey, $array1)
            && !array_key_exists($mergeKey, $array2)
    ) {
          $action = 'removed';

        if (is_array($array1[$mergeKey])) {
            $value = diff($array1[$mergeKey], $array1[$mergeKey]);
        } else {
            $value = $array1[$mergeKey];
        }
    }

      // Key doesn't exists in array1 and exists in array2
    if (
            !array_key_exists($mergeKey, $array1)
            && array_key_exists($mergeKey, $array2)
    ) {
        $action = 'added';

        if (is_array($array2[$mergeKey])) {
            $value = diff($array2[$mergeKey], $array2[$mergeKey]);
        } else {
            $value = $array2[$mergeKey];
        }
    }

    return [
        'property' => $mergeKey,
        'action' => $action,
        'value' => $value,
        'new value' => $newValue,
    ];
}

function diff(array $array1, array $array2): array
{
    $mergeKeys = array_unique(array_merge(array_keys($array1), array_keys($array2)));
    asort($mergeKeys);

    $arrayDiff = array_map(function ($mergeKey) use ($array1, $array2) {

        return createArrayDiff($array1, $array2, $mergeKey);
    }, $mergeKeys);

        return $arrayDiff;
}
function genDiff(string $pathFile1, string $pathFile2, string $formatter = 'stylish'): string
{
    $array1 = getContentFromFile($pathFile1);
    $array2 = getContentFromFile($pathFile2);

    return formatter(diff($array1, $array2), $formatter);
}
