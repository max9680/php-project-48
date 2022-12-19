<?php

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff(): void
    {
        $testResult = "{\n  - follow: false\n    host: hexlet.io\n  - proxy: 123.234.53.22\n  - timeout: 50\n  + timeout: 20\n  + verbose: true\n}";
        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1.json", "./tests/fixtures/file2.json"));
        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1.yml", "./tests/fixtures/file2.yml"));
    }

    public function testGenDiffNested(): void
    {
        $testResult = file_get_contents("tests/fixtures/stylish.txt");

        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.json", "./tests/fixtures/file2n.json"));
        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.yml", "./tests/fixtures/file2n.yml"));
    }

    public function testGenDiffPlain(): void
    {
        $testResult = file_get_contents("tests/fixtures/plain.txt");

        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.json", "./tests/fixtures/file2n.json", 'plain'));
        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.yml", "./tests/fixtures/file2n.yml", 'plain'));
    }

    public function testGenDiffJson(): void
    {
        $testResult = file_get_contents("tests/fixtures/json.txt");

        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.json", "./tests/fixtures/file2n.json", 'json'));
        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.yml", "./tests/fixtures/file2n.yml", 'json'));
    }
}