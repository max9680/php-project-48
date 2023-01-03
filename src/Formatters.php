<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\stylish;
use function Differ\Formatters\Plain\plain;
use function Differ\Formatters\Json\json;

function valueAsString($value): string
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

function formatter(array $array, string $formatter): string
{
    switch ($formatter) {
        case 'stylish':
            return "{\n" . stylish($array) . "}";
        case 'plain':
            return substr(plain($array), 0, -1);
        case 'json':
            return json_encode(json($array));
        default:
            throw new \Exception("Unknown format");
    }
}
