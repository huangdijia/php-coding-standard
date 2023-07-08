# PHP Coding Standard

[![Latest Stable Version](https://poser.pugx.org/huangdijia/php-coding-standard/v)](//packagist.org/packages/huangdijia/php-coding-standard)
[![Total Downloads](https://poser.pugx.org/huangdijia/php-coding-standard/downloads)](//packagist.org/packages/huangdijia/php-coding-standard)
[![License](https://poser.pugx.org/huangdijia/php-coding-standard/license)](//packagist.org/packages/huangdijia/php-coding-standard)
[![PHP Version Require](https://poser.pugx.org/huangdijia/php-coding-standard/require/php)](//packagist.org/packages/huangdijia/php-coding-standard)

Standards for Personal Use.

## Usage

Install via composer.

```shell
composer require huangdijia/php-coding-standard --dev
```

Replace `vendor/huangdijia/.php-cs-fixer.php.stub` with your own `.php-cs-fixer.php` file.

```shell
cp vendor/huangdijia/php-coding-standard/.php-cs-fixer.php.stub .php-cs-fixer.php
```

Replace `friendsofphp/php-cs-fixer` with the wrapper provided by this package.

```shell
composer remove friendsofphp/php-cs-fixer --dev --no-update
composer require huangdijia/php-coding-standard --dev --no-update
composer update -o
cp vendor/huangdijia/php-coding-standard/.php-cs-fixer.php.stub .php-cs-fixer.php
```

## License

MIT
