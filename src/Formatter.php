<?php

namespace Differ\Formatter;

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

function formatter($array, $formatter, $depth = 0, $result = '')
{
    switch ($formatter) {
        case 'stylish':
            if ($depth == 0) {
                $result = $result . "{\n";
            }

            foreach ($array as $index => $key) {
                if (is_array($key)) {
                    $result = $result . str_repeat('    ', $depth) . $index . ": {\n";
                    $result = $result . formatter($key, $formatter, $depth + 1) . "\n";
                } else {
                    $result = $result . str_repeat('    ', $depth) . $index . ": " . valueAsString($key) . "\n";
                }
            }

            if ($depth == 0) {
                $result = $result . "}";
            } else {
                $result = $result . str_repeat('    ', $depth) . "}";
            }
            break;
    }
    return $result;
}
