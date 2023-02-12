# ENV: php-dotenv

*By [srdorado](https://github.com/srdorado)* 

*Base code [devcoder-xyz](https://github.com/devcoder-xyz)*

# Loads environment variables from .env file to getenv(), $_ENV and $_SERVER.
[![License](https://img.shields.io/packagist/l/srdorado/siigo-client-php)](https://packagist.org/packages/srdorado/php-dotenv)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/srdorado/php-dotenv)
[![Packagist Version](https://img.shields.io/packagist/v/srdorado/php-dotenv)](https://packagist.org/packages/srdorado/php-dotenv)
[![Packagist Downloads](https://img.shields.io/packagist/dt/srdorado/php-dotenv)](https://packagist.org/packages/srdorado/php-dotenv)
[![Composer dependencies](https://img.shields.io/badge/dependencies-0-brightgreen)](https://github.com/srdorado/php-dotenv/blob/master/composer.json)
[![Test workflow](https://img.shields.io/github/workflow/status/srdorado/php-dotenv/test?label=test&logo=github)](https://github.com/srdorado/php-dotenv/actions?workflow=test)
[![Codecov](https://img.shields.io/codecov/c/github/srdorado/php-dotenv?logo=codecov)](https://codecov.io/gh/srdorado/php-dotenv)
[![composer.lock](https://poser.pugx.org/srdorado/php-dotenv/composerlock)](https://packagist.org/packages/srdorado/php-dotenv)


## Installation

Use [Composer](https://getcomposer.org/)

### Composer Require
```
composer require srdorado/php-dotenv
```

## Requirements

* PHP version >= 5.4

**How to use ?**

```
APP_ENV=dev
DATABASE_DNS=mysql:host=localhost;dbname=test;
DATABASE_USER="root"
DATABASE_PASSWORD=root
MODULE_ENABLED=true
NUMBER_LITERAL=0
NULL_VALUE=null
```

## Load the variables

```php
<?php
use Srdorado\Env\DotEnv;

$absolutePathToEnvFile = __DIR__ . '/.env';

(new DotEnv($absolutePathToEnvFile))->load();
```

# Use them!
```php
/**
 * string(33) "mysql:host=localhost;dbname=test;" 
 */
var_dump(getenv('DATABASE_DNS'));

/**
 * Removes double and single quotes from the variable:
 * 
 * string(4) "root" 
 */
var_dump(getenv('DATABASE_USER'));

/**
 * Processes booleans as such:
 * 
 * bool(true) 
 */
var_dump(getenv('MODULE_ENABLED'));

/**
 * Process the numeric value:
 * 
 * int(0) 
 */
var_dump(getenv('NUMBER_LITERAL'));

/**
 * Check for literal null values:
 * 
 * NULL
 */
var_dump(getenv('NULL_VALUE'));
```

Ideal for small project

Simple and easy!

# Processors

Also the variables are parsed according to the configuration passed as parameter to the constructor. The available processors are:

## BooleanProcessor

``VARIABLE=false`` will be processed to ```bool(false)```

NOTE: ``VARIABLE="true"`` will be processed to ```string(4) "true"```

## QuotedProcessor

``VARIABLE="anything"`` will be processed to ```string(8) "anything"```

## NullProcessor

``VARIABLE=null`` will be processed to ```NULL```

## NumberProcessor

``VARIABLE=0`` will be processed to ```int(0)```

``VARIABLE=0.1`` will be processed to ```float(0.1)```

## Base code

Due to the need to create a library to manage environment variables through a configuration file that is compatible with php versions >= 5.4, it was decided to use as a base the code published under the MIT license in:
https://github.com/devcoder-xyz/php-dotenv