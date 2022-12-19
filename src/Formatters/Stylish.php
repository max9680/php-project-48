<?php

namespace Differ\Formatters\Stylish;

use function Differ\Formatters\valueAsString;

function stylish(array $array, int $depth = 0, string $result = ''): string
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
