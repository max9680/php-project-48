<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function getContentFromFile($pathFile)
{
    $formatFile = explode(".", $pathFile)[1];

    switch ($formatFile) {
        case 'json':
            {
                $contentFile = file_get_contents($pathFile);
                $resultArray = json_decode($contentFile, true, 512, JSON_OBJECT_AS_ARRAY);

                return $resultArray;
            }
        case 'yml':
        case 'yaml':
            {
                $resultArray = Yaml::parseFile($pathFile);

                return $resultArray;
            }
    }

}


