<?php

namespace Differ\Formatters\Plain;

use function Differ\Formatters\valueAsString;

const ADD = "  + ";
const REMOVE = "  - ";

function normalizeValue($value)
{
    if (is_array($value)) {
        return '[complex value]';
    }

    if (is_string($value)) {
        return "'" . $value . "'";
    } else {
        return valueAsString($value);
    }
}

function plain($array, $path = '', $result = '')
{
    if ($path !== '') {
        $path = $path . '.';
    }

    $keys = array_keys($array);

    foreach ($keys as $key) {
            $keyPrefix = substr($key, 0, 4);
            $keyWord = substr($key, 4, strlen($key));
            // var_dump($keyPrefix);
            // var_dump($keyWord);

        if (($keyPrefix == "    ") && (is_array($array[$key]))) {
            $result = $result . plain($array[$key], $path . $keyWord);
          // $path = $keyWord;
          // var_dump($keyWord);
        }

        if (($keyPrefix == REMOVE) && !array_key_exists(ADD . $keyWord, $array)) {
            $result = $result . "Property " . normalizeValue($path . $keyWord) . " was removed\n";
        }

        if (($keyPrefix == ADD) && !array_key_exists(REMOVE . $keyWord, $array)) {
            $result = $result . "Property " . normalizeValue($path . $keyWord)
             . " was added with value: " . normalizeValue($array[$key]) . "\n";
        }

        if (($keyPrefix == REMOVE) && array_key_exists(ADD . $keyWord, $array)) {
              $result = $result . "Property " . normalizeValue($path . $keyWord) . " was updated. From "
               . normalizeValue($array[REMOVE . $keyWord]) . " to " .  normalizeValue($array[ADD . $keyWord]) . "\n";
        }
    }

        return $result;
}