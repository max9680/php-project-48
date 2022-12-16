<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\stylish;
use function Differ\Formatters\Plain\plain;

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

function formatter($array, $formatter)
{
    switch ($formatter) {
        case 'stylish':
            return stylish($array);
        case 'plain':
            return plain($array);
    }

    return stylish($array);
}
