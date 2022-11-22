<?php

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff(): void
    {
        $testResult = "- follow: false\n  host: hexlet.io\n- proxy: 123.234.53.22\n- timeout: 50\n+ timeout: 20\n+ verbose: true\n";
        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1.json", "./tests/fixtures/file2.json"));
        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1.yml", "./tests/fixtures/file2.yml"));
    }
}