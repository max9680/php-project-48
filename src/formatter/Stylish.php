<?php

namespace Differ\Formatter\Stylish;

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

function stylish($array, $depth = 0, $result = '')
{
    if ($depth == 0) {
        $result = $result . "{\n";
    }

    foreach ($array as $index => $key) {
        if (is_array($key)) {
            $result = $result . str_repeat('    ', $depth) . $index . ": {\n";
            $result = $result . stylish($key, $depth + 1) . "\n";
        } else {
            $result = $result . str_repeat('    ', $depth) . $index . ": " . valueAsString($key) . "\n";
        }
    }

    if ($depth == 0) {
        $result = $result . "}";
    } else {
        $result = $result . str_repeat('    ', $depth) . "}";
    }

    return $result;
}
