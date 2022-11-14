<?php

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff(): void
    {
        $testResult = "- follow: false\n  host: hexlet.io\n- proxy: 123.234.53.22\n- timeout: 50\n+ timeout: 20\n+ verbose: true\n";
        $this->assertEquals($testResult, genDiff("/home/maxim/php-project-48/file1.json", "/home/maxim/php-project-48/file2.json"));
    }
}