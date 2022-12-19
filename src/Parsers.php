<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function getContentFromFile(string $pathFile)
{
    $formatFile = explode(".", $pathFile);
    $formatFile = end($formatFile);

    switch ($formatFile) {
        case 'json':
                $contentFile = file_get_contents($pathFile);
                $resultArray = json_decode($contentFile, true, 512, JSON_OBJECT_AS_ARRAY);
            return $resultArray;
        case 'yml' || 'yaml':
                $resultArray = Yaml::parseFile($pathFile);
            return $resultArray;
    }
}
