<?php

namespace Differ\Formatters\Stylish;

use function Differ\Formatters\valueAsString;

function stylish(array $array, int $depth = 1): string
{
        $output = array_reduce($array, function ($result, $item) use ($depth) {
            switch ($item['action']) {
                case 'same':
                    if (is_array($item['value'])) {
                        $result = $result . str_repeat('    ', $depth) . $item['property'] . ": {\n";
                        $result = $result . stylish($item['value'], $depth + 1) . str_repeat('    ', $depth) . "}\n";
                    } else {
                        $result = $result . str_repeat('    ', $depth) . $item['property'] . ": "
                        . valueAsString($item['value']) . "\n";
                    }
                    break;
                case 'added':
                    if (is_array($item['value'])) {
                        $result = $result . str_repeat('    ', $depth - 1) . '  + ' . $item['property'] . ": {\n";
                        $result = $result . stylish($item['value'], $depth + 1) . str_repeat('    ', $depth) . "}\n";
                    } else {
                        $result = $result . str_repeat('    ', $depth - 1) . '  + ' . $item['property']
                        . ": " . valueAsString($item['value']) . "\n";
                    }
                    break;
                case 'removed':
                    if (is_array($item['value'])) {
                        $result = $result . str_repeat('    ', $depth - 1) . '  - ' . $item['property']
                        . ": {\n";
                        $result = $result . stylish($item['value'], $depth + 1) . str_repeat('    ', $depth)
                        . "}\n";
                    } else {
                        $result = $result . str_repeat('    ', $depth - 1) . '  - ' . $item['property'] . ": "
                        . valueAsString($item['value']) . "\n";
                    }
                    break;
                case 'updated':
                    if (is_array($item['value'])) {
                        $result = $result . str_repeat('    ', $depth - 1)
                        . '  - ' . $item['property'] . ": {\n";
                        $result = $result . stylish($item['value'], $depth + 1)
                        . str_repeat('    ', $depth) . "}\n";
                        $result = $result . str_repeat('    ', $depth - 1)
                        . '  + ' . $item['property'] . ": " . valueAsString($item['new value']) . "\n";
                    } else {
                        $result = $result . str_repeat('    ', $depth - 1) . '  - ' . $item['property']
                        . ": " . valueAsString($item['value']) . "\n";

                        if (is_array($item['new value'])) {
                            $result = $result . str_repeat('    ', $depth - 1) . '  + ' . $item['property']
                            . ": " . stylish($item['new value'], $depth + 1) . "\n";
                        } else {
                            $result = $result . str_repeat('    ', $depth - 1) . '  + ' . $item['property']
                            . ": " . valueAsString($item['new value']) . "\n";
                        }
                    }
                    break;
            }


            return $result;
        }, '');

        return $output;
}
