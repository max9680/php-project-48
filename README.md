### Hexlet tests and linter status:
[![Actions Status](https://github.com/max9680/php-project-48/workflows/hexlet-check/badge.svg)](https://github.com/max9680/php-project-48/actions)
[![differ-test](https://github.com/max9680/php-project-48/actions/workflows/differ-test.yml/badge.svg)](https://github.com/max9680/php-project-48/actions/workflows/differ-test.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/34e6316e9cb30aba4c11/maintainability)](https://codeclimate.com/github/max9680/php-project-48/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/34e6316e9cb30aba4c11/test_coverage)](https://codeclimate.com/github/max9680/php-project-48/test_coverage)

## Gendiff utility:
Utility compares json and yml files. Output can be displayed in few formats - stylish, plain and json.

## Requirements
* PHP >= 7.4
* [Composer](https://getcomposer.org/)

## Install
```sh
$ git clone git@github.com:max9680/php-project-48.git

$ cd php-project-48/

$ make install
```

## Usage
gendiff (-h|--help)

gendiff (-v|--version)

gendiff [--format `<fmt`>] `<firstFile`> `<secondFile`>

## Options
-h --help emsp Show this screen

-v --version            Show version

--format <fmt>          Report format [default: stylish]

## Examples of usage
```sh
$ gendiff ./tests/fixtures/file1n.json ./tests/fixtures/file2n.json --format json

$ gendiff ./tests/fixtures/file1n.yml ./tests/fixtures/file2n.yml --format stylish

$ gendiff ./tests/fixtures/file1.json ./tests/fixtures/file2.json --format plain
```

#### Comparison of json-files:
[![asciicast](https://asciinema.org/a/WXPdEVnjaRF9Z7cf0d4DP0wzU.svg)](https://asciinema.org/a/WXPdEVnjaRF9Z7cf0d4DP0wzU?autoplay=1)

#### Comparison of yml-files:
[![asciicast](https://asciinema.org/a/12XPBMaak8qZslYcwGnX0s3do.svg)](https://asciinema.org/a/12XPBMaak8qZslYcwGnX0s3do?autoplay=1)

#### Using format option:
[![asciicast](https://asciinema.org/a/i2eeb4y2f5MilPbbzcFkWlKV5.svg)](https://asciinema.org/a/i2eeb4y2f5MilPbbzcFkWlKV5?autoplay=1)

#### Using stylish and plain format option:
[![asciicast](https://asciinema.org/a/kNHiQkzbVki8xzo07QOmH66S0.svg)](https://asciinema.org/a/kNHiQkzbVki8xzo07QOmH66S0?autoplay=1)

#### Using json format option:
[![asciicast](https://asciinema.org/a/N9Tf8wsvdsSp3DN6nWINtVxz3.svg)](https://asciinema.org/a/N9Tf8wsvdsSp3DN6nWINtVxz3?autoplay=1)