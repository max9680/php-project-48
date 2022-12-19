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
        $testResult = "{
    common: {
      + follow: false
        setting1: Value 1
      - setting2: 200
      - setting3: true
      + setting3: null
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
        setting6: {
            doge: {
              - wow: 
              + wow: so much
            }
            key: value
          + ops: vops
        }
    }
    group1: {
      - baz: bas
      + baz: bars
        foo: bar
      - nest: {
            key: value
        }
      + nest: str
    }
  - group2: {
        abc: 12345
        deep: {
            id: 45
        }
    }
  + group3: {
        deep: {
            id: {
                number: 45
            }
        }
        fee: 100500
    }
}";
        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.json", "./tests/fixtures/file2n.json"));
        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.yml", "./tests/fixtures/file2n.yml"));
    }

    public function testGenDiffPlain(): void
    {
        $testResult = "Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]\n";

        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.json", "./tests/fixtures/file2n.json", 'plain'));
        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.yml", "./tests/fixtures/file2n.yml", 'plain'));
    }

    public function testGenDiffJson(): void
    {
        $testResult = {"    common":{"  + follow":false,"    setting1":"Value 1",
          "  - setting2":200,"  - setting3":true,"  + setting3":null,"  + setting4":"blah blah",
          "  + setting5":{"    key5":"value5"},"    setting6":{"    doge":{"  - wow":"","  + wow":"so much"},
          "    key":"value","  + ops":"vops"}},"    group1":{"  - baz":"bas","  + baz":"bars","    foo":"bar",
          "  - nest":{"    key":"value"},"  + nest":"str"},"  - group2":{"    abc":12345,"    deep":{"    id":45}},
          "  + group3":{"    deep":{"    id":{"    number":45}},"    fee":100500}};

        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.json", "./tests/fixtures/file2n.json", 'json'));
        $this->assertEquals($testResult, genDiff("./tests/fixtures/file1n.yml", "./tests/fixtures/file2n.yml", 'json'));
    }
}