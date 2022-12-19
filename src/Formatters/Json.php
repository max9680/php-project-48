<?php

namespace Differ\Formatters\Json;

function json(array $array): string
{
    return json_encode($array);
}
