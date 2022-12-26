<?php

namespace Differ\Formatters\Json;

function json(array $array): array
{
    foreach ($array as $item) {
        if ($item['action'] == 'removed') {
            $index = '  - ' . $item['property'];

            if (is_array($item['value'])) {
                $result[$index] = json($item['value']);
            } else {
                $result[$index] = $item['value'];
            }
        }

        if ($item['action'] == 'added') {
            $index = '  + ' . $item['property'];

            if (is_array($item['value'])) {
                $result[$index] = json($item['value']);
            } else {
                $result[$index] = $item['value'];
            }
        }

        if ($item['action'] == 'updated') {
            $index = '  - ' . $item['property'];

            if (is_array($item['value'])) {
                $result[$index] = json($item['value']);
            } else {
                $result[$index] = $item['value'];
            }

            $index = '  + ' . $item['property'];

            if (is_array($item['new value'])) {
                $result[$index] = json($item['new value']);
            } else {
                $result[$index] = $item['new value'];
            }
        }

        if ($item['action'] == 'same') {
            $index = '    ' . $item['property'];

            if (is_array($item['value'])) {
                $result[$index] = json($item['value']);
            } else {
                $result[$index] = $item['value'];
            }
        }
    }

    return $result;
}
