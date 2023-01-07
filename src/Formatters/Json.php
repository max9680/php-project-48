<?php

namespace Differ\Formatters\Json;

use function Functional\map;

function json(array $array): array
{
    $arrayForJson = array_reduce($array, function ($result, $item) {

        $index1 = null;
        $value1 = null;

        if ($item['action'] == 'removed') {
            $index = '  - ' . $item['property'];

            if (is_array($item['value'])) {
                $value = json($item['value']);
            } else {
                $value = $item['value'];
            }
        }

        if ($item['action'] == 'added') {
            $index = '  + ' . $item['property'];

            if (is_array($item['value'])) {
                $value = json($item['value']);
            } else {
                $value = $item['value'];
            }
        }

        if ($item['action'] == 'updated') {
            $index = '  - ' . $item['property'];

            if (is_array($item['value'])) {
                $value = json($item['value']);
            } else {
                $value = $item['value'];
            }

            $index1 = '  + ' . $item['property'];

            if (is_array($item['new value'])) {
                $value1 = json($item['new value']);
            } else {
                $value1 = $item['new value'];
            }
        }

        if ($item['action'] == 'same') {
            $index = '    ' . $item['property'];

            if (is_array($item['value'])) {
                $value = json($item['value']);
            } else {
                $value = $item['value'];
            }
        }

        if ($index1 == null) {
            return array_merge($result, [$index => $value]);
        } else {
            return array_merge($result, [$index => $value, $index1 => $value1]);
        }
    }, []);

    return $arrayForJson;
}
