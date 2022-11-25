<?php

namespace Differ\Differ;

use function Differ\Parsers\getContentFromFile;

function boolValueAsString($key, $value)
{
    if ($value === true) {
        return "true";
    } else {
        return "false";
    }
}

function genDiff($pathFile1, $pathFile2)
{
    $array1 = getContentFromFile($pathFile1);
    $array2 = getContentFromFile($pathFile2);

    $result = "";

    ksort($array1);
    ksort($array2);

    foreach ($array1 as $key => $value) {
        if (array_key_exists($key, $array2)) {
            if ($array1[$key] === $array2[$key]) {
                $result .= (is_bool($array1[$key]))
                ? "  " . "$key" . ": " . boolValueAsString($key, $array1[$key])
                 . "\n"
                : "  " . "$key" . ": " . "$array1[$key]\n";

                unset($array2[$key]);
            } else {
                $result .= (is_bool($array1[$key]))
                ? "- " . "$key" . ": " . boolValueAsString($key, $array1[$key])
                 . "\n"
                : "- " . "$key" . ": " . "$array1[$key]\n";

                $result .= (is_bool($array2[$key]))
                ? "+ " . "$key" . ": " . boolValueAsString($key, $array2[$key])
                 . "\n"
                : "+ " . "$key" . ": " . "$array2[$key]\n";

                unset($array2[$key]);
            }
        } else {
            $result .= (is_bool($array1[$key]))
            ? "- " . "$key" . ": " . boolValueAsString($key, $array1[$key])
             . "\n"
            : "- " . "$key" . ": " . "$array1[$key]\n";
        }
    }


    foreach ($array2 as $key => $value) {
        $result .= (is_bool($array2[$key]))
        ? "+ " . "$key" . ": " . boolValueAsString($key, $array2[$key])
        . "\n"
        : "+ " . "$key" . ": " . "$array2[$key]\n";
    }

    return $result;
}
