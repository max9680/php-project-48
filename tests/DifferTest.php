<?php

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff(): void
    {
        $testResult = "
        - follow: false
          host: hexlet.io
        - proxy: 123.234.53.22
        - timeout: 50
        + timeout: 20
        + verbose: true";
        $this->assertEquals($testResult, genDiff("/home/maxim/php-project-48/file1.json", "/home/maxim/php-project-48/file2.json"));
    }
}