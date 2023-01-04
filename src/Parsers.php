<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function getContentFromFile(string $pathFile): array
{
    $explodeFilePath = explode(".", $pathFile);
    $formatFile = end($explodeFilePath);

    switch ($formatFile) {
        case 'json':
                $contentFile = file_get_contents($pathFile);
                $resultArray = json_decode($contentFile, true, 512, JSON_OBJECT_AS_ARRAY);
            return $resultArray;

        case 'yml':
            $resultArray = Yaml::parseFile($pathFile);
            return $resultArray;

        case 'yaml':
            $resultArray = Yaml::parseFile($pathFile);
            return $resultArray;

        default:
            throw new \Exception("Unknown input file format");
    }
}
