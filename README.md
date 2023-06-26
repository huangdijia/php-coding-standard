# PHP Coding Standard

[![Latest Stable Version](https://poser.pugx.org/huangdijia/php-coding-standard/v)](//packagist.org/packages/huangdijia/php-coding-standard)
[![Total Downloads](https://poser.pugx.org/huangdijia/php-coding-standard/downloads)](//packagist.org/packages/huangdijia/php-coding-standard)
[![License](https://poser.pugx.org/huangdijia/php-coding-standard/license)](//packagist.org/packages/huangdijia/php-coding-standard)
[![PHP Version Require](https://poser.pugx.org/huangdijia/php-coding-standard/require/php)](//packagist.org/packages/huangdijia/php-coding-standard)

Standards for Personal Use.

## Usage

```shell
composer require huangdijia/php-coding-standard --dev
```

```shell
touch .php-cs-fixer.php
```

```php
<?php

use Huangdijia\PhpCsFixer\Config;

require __DIR__ . '/vendor/autoload.php';

return (new Config())
    ->setHeaderComment(
        projectName: 'foo/bar',
        projectLink: 'https://github.com/foo/bar',
        contacts: [
            'Foo' => 'foo@bar.com',
        ],
    )
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('public')
            ->exclude('runtime')
            ->exclude('vendor')
            ->in(__DIR__)
            ->append([
                __FILE__,
            ])
    )
    ->setUsingCache(false);

```
