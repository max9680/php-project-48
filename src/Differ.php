<?php

namespace Differ\Differ;

use function Differ\Parsers\getContentFromFile;
use function Differ\Formatters\formatter;

function diff(array $array1, array $array2)
{
    $mergeKeys = array_unique(array_merge(array_keys($array1), array_keys($array2)));
    asort($mergeKeys);

    $result = [];

    $arrayDiff = array_reduce($mergeKeys, function ($result, $mergeKey) use ($array1, $array2) {

      // Key exists in array1 and array2
        if (
            array_key_exists($mergeKey, $array1)
            && array_key_exists($mergeKey, $array2)
        ) {
          //Value is array in $array1 and $array2
            if (is_array($array1[$mergeKey]) && is_array($array2[$mergeKey])) {
                $result['    ' . $mergeKey] = diff($array1[$mergeKey], $array2[$mergeKey]);
                return $result;
            }

          //Value is array in $array1 and  not array in $array2
            if (is_array($array1[$mergeKey]) && !is_array($array2[$mergeKey])) {
                $result['  - ' . $mergeKey] = diff($array1[$mergeKey], $array1[$mergeKey]);
                $result['  + ' . $mergeKey] = $array2[$mergeKey];
            }

          //Value is  not array in $array1 and array in $array2
            if (!is_array($array1[$mergeKey]) && is_array($array2[$mergeKey])) {
                $result['  - ' . $mergeKey] = $array1[$mergeKey];
                $result['  + ' . $mergeKey] = diff($array2[$mergeKey], $array2[$mergeKey]);
            }
          //Value is not array in $array1 and  not array in $array2
            if (!is_array($array1[$mergeKey]) && !is_array($array2[$mergeKey])) {
                if ($array1[$mergeKey] == $array2[$mergeKey]) {
                    $result['    ' . $mergeKey] = $array1[$mergeKey];
                } else {
                    $result['  - ' . $mergeKey] = $array1[$mergeKey];
                    $result['  + ' . $mergeKey] = $array2[$mergeKey];
                }
            }
        }

      // Key exists in array1 and doesn't exist in array2
        if (
            array_key_exists($mergeKey, $array1)
            && !array_key_exists($mergeKey, $array2)
        ) {
            if (is_array($array1[$mergeKey])) {
                $result['  - ' . $mergeKey] = diff($array1[$mergeKey], $array1[$mergeKey]);
            } else {
                $result['  - ' . $mergeKey] = $array1[$mergeKey];
            }
        }

      // Key doesn't exists in array1 and exists in array2
        if (
            !array_key_exists($mergeKey, $array1)
            && array_key_exists($mergeKey, $array2)
        ) {
            if (is_array($array2[$mergeKey])) {
                $result['  + ' . $mergeKey] = diff($array2[$mergeKey], $array2[$mergeKey]);
            } else {
                $result['  + ' . $mergeKey] = $array2[$mergeKey];
            }
        }

        return $result;
    }, []);

    return $arrayDiff;
}

function genDiff($pathFile1, $pathFile2, $formatter = 'stylish')
{
    $array1 = getContentFromFile($pathFile1);
    $array2 = getContentFromFile($pathFile2);

    return formatter(diff($array1, $array2), $formatter);
}
