[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/bogkov/execution-speed/master/LICENSE)
[![Latest Stable Version](https://img.shields.io/packagist/v/bogkov/execution-speed.svg)](https://packagist.org/packages/bogkov/execution-speed)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg)](https://php.net/)
[![Build Status](https://travis-ci.org/bogkov/execution-speed.svg)](https://travis-ci.org/bogkov/execution-speed)
[![codecov](https://img.shields.io/codecov/c/github/bogkov/execution-speed.svg)](https://codecov.io/gh/bogkov/execution-speed)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bogkov/execution-speed/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bogkov/execution-speed/?branch=master)

# Execution Speed

This component provides the functionality to calculate the execution speed

## Installation

This package can be installed as a [Composer](https://getcomposer.org/) dependency [bogkov/execution-speed](https://packagist.org/packages/bogkov/execution-speed)

```bash
composer require bogkov/execution-speed
```

## Usage

```php
<?php
$executionSpeed = new Bogkov\ExecutionSpeed\ExecutionSpeed($max = 50);
$executionSpeed->push($count = 100, $duration = 10);
$executionSpeed->push($count = 120, $duration = 11);
$executionSpeed->push($count = 90, $duration = 8);

echo 'Speed: ' . $executionSpeed->getSpeed($coefficient = 0.3, $precision = 0);
```