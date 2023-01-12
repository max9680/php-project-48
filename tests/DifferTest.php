<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
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
