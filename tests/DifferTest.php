<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function additionProvider(): array
    {
        return [
            'json format' => ['json'],
            'yml format' => ['yml']
        ];
    }

    /**
     * @dataProvider additionProvider
     */
    public function testGenDiff(string $format): void
    {
        $testResult = file_get_contents("tests/fixtures/stylish.txt");

        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.{$format}", "./tests/fixtures/file2n.{$format}"));
    }

    /**
     * @dataProvider additionProvider
     */
    public function testGenDiffStylish(string $format): void
    {
        $testResult = file_get_contents("tests/fixtures/stylish.txt");

        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.{$format}", "./tests/fixtures/file2n.{$format}", 'stylish'));
    }

    /**
     * @dataProvider additionProvider
     */
    public function testGenDiffPlain(string $format): void
    {
        $testResult = file_get_contents("tests/fixtures/plain.txt");

        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.{$format}", "./tests/fixtures/file2n.{$format}", 'plain'));
    }

    /**
     * @dataProvider additionProvider
     */
    public function testGenDiffJson(string $format): void
    {
        $testResult = file_get_contents("tests/fixtures/json.txt");

        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.{$format}", "./tests/fixtures/file2n.{$format}", 'json'));
    }
}
