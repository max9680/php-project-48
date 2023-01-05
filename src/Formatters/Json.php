<?php

namespace Differ\Formatters\Json;

function json(array $array): array
{
    $arrayForJson = array_reduce($array, function ($result, $item) {
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
            $result[$index] = $value;

            $index = '  + ' . $item['property'];

            if (is_array($item['new value'])) {
                $value = json($item['new value']);
            } else {
                $value = $item['new value'];
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
        $result[$index] = $value;

        return $result;
    }, []);

    return $arrayForJson;
}
