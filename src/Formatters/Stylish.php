<?php

namespace Differ\Formatters\Stylish;

use function Differ\Formatters\valueAsString;

function stylish(array $array, int $depth = 1): string
{
        $output = array_reduce($array, function (string $result, array $item) use ($depth) {
            if (!is_array($item)) {
                print_r($item);
            }

            switch ($item['action']) {
                case 'same':
                    if (is_array($item['value'])) {
                        return $result . str_repeat('    ', $depth) . $item['property'] . ": {\n"
                        . stylish($item['value'], $depth + 1) . str_repeat('    ', $depth) . "}\n";
                    } else {
                        return $result . str_repeat('    ', $depth) . $item['property'] . ": "
                        . valueAsString($item['value']) . "\n";
                    }
                    break;
                case 'added':
                    if (is_array($item['value'])) {
                        return $result . str_repeat('    ', $depth - 1) . '  + ' . $item['property']
                        . ": {\n" . stylish($item['value'], $depth + 1) . str_repeat('    ', $depth) . "}\n";
                    } else {
                        return $result . str_repeat('    ', $depth - 1) . '  + ' . $item['property']
                        . ": " . valueAsString($item['value']) . "\n";
                    }
                    break;
                case 'removed':
                    if (is_array($item['value'])) {
                        return $result . str_repeat('    ', $depth - 1) . '  - ' . $item['property']
                        . ": {\n" . stylish($item['value'], $depth + 1) . str_repeat('    ', $depth)
                        . "}\n";
                    } else {
                        return $result . str_repeat('    ', $depth - 1) . '  - ' . $item['property'] . ": "
                        . valueAsString($item['value']) . "\n";
                    }
                    break;
                case 'updated':
                    if (is_array($item['value'])) {
                        if (is_array($item['new value'])) {
                            return $result . str_repeat('    ', $depth - 1)
                            . '  - ' . $item['property'] . ": {\n"
                            . stylish($item['value'], $depth + 1)
                            . str_repeat('    ', $depth) . "}\n"
                            . str_repeat('    ', $depth - 1) . '  + ' . $item['property']
                        . ": {\n" . stylish($item['new value'], $depth + 1) . str_repeat('    ', $depth) . "}\n";
                            } else {
                                return $result . str_repeat('    ', $depth - 1)
                                . '  - ' . $item['property'] . ": {\n"
                                . stylish($item['value'], $depth + 1)
                                . str_repeat('    ', $depth) . "}\n"
                                . str_repeat('    ', $depth - 1) . '  + ' . $item['property']
                        . ": " . valueAsString($item['new value']) . "\n";
                            }
                        // $result = $result . str_repeat('    ', $depth - 1)
                        // . '  + ' . $item['property'] . ": " . valueAsString($item['new value']) . "\n";
                    } else {
                        if (is_array($item['new value'])) {
                        return $result . str_repeat('    ', $depth - 1) . '  - ' . $item['property']
                        . ": " . valueAsString($item['value']) . "\n"
                        . str_repeat('    ', $depth - 1) . '  + ' . $item['property']
                        . ": {\n" . stylish($item['new value'], $depth + 1) . str_repeat('    ', $depth) . "}\n";
                        } else {
                            return $result . str_repeat('    ', $depth - 1) . '  - ' . $item['property']
                        . ": " . valueAsString($item['value']) . "\n"
                        . str_repeat('    ', $depth - 1) . '  + ' . $item['property']
                        . ": " . valueAsString($item['new value']) . "\n";
                        }
                    }

                    // if (is_array($item['new value'])) {
                    //     $result = $result . str_repeat('    ', $depth - 1) . '  + ' . $item['property']
                    //     . ": {\n" . stylish($item['new value'], $depth + 1) . str_repeat('    ', $depth) . "}\n";
                    // } else {
                    //     // print_r($item['new value']);
                    //     $result = $result . str_repeat('    ', $depth - 1) . '  + ' . $item['property']
                    //     . ": " . valueAsString($item['new value']) . "\n";
                    // }
                    break;
            }


            return $result;
        }, '');

        return $output;
}
