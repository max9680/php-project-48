<?php

namespace Differ\Formatters\Plain;

use function Differ\Formatters\valueAsString;

use const Differ\Differ\ADD;
use const Differ\Differ\REMOVE;

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

function plain(array $array, string $path = ''): string
{
    $output = array_reduce($array, function ($result, $item) use ($path) {
        if ($item['action'] == 'same' && is_array($item['value'])) {
            $result = $result . plain($item['value'], $path . $item['property'] . ".");
        }

        if ($item['action'] == 'added') {
            $result = $result . "Property " . normalizeValue($path . $item['property'])
            . " was added with value: " . normalizeValue($item['value']) . "\n";
        }

        if ($item['action'] == 'removed') {
            $result = $result . "Property " . normalizeValue($path . $item['property'])
            . " was removed\n";
        }

        if ($item['action'] == 'updated') {
            $result = $result . "Property " . normalizeValue($path . $item['property']) . " was updated. From "
            . normalizeValue($item['value']) . " to " . normalizeValue($item['new value']) . "\n";
        }

        return $result;
    }, '');

    return $output;
}
