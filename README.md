# PHP Coding Standard

[![Latest Stable Version](https://poser.pugx.org/huangdijia/php-coding-standard/v)](//packagist.org/packages/huangdijia/php-coding-standard)
[![Total Downloads](https://poser.pugx.org/huangdijia/php-coding-standard/downloads)](//packagist.org/packages/huangdijia/php-coding-standard)
[![License](https://poser.pugx.org/huangdijia/php-coding-standard/license)](//packagist.org/packages/huangdijia/php-coding-standard)
[![PHP Version Require](https://poser.pugx.org/huangdijia/php-coding-standard/require/php)](//packagist.org/packages/huangdijia/php-coding-standard)
[![CI](https://github.com/huangdijia/php-coding-standard/workflows/CI/badge.svg)](https://github.com/huangdijia/php-coding-standard/actions)

A comprehensive PHP coding standard configuration based on PHP CS Fixer for personal and team use.

## Features

- 🚀 Based on industry-standard rulesets (PSR-2, Symfony, PhpCsFixer)
- 🎯 Optimized for modern PHP 8.1+ development
- 🔧 Easily customizable with additional rules
- 📝 Automatic header comment generation
- ⚡ Parallel processing support for faster execution
- 🎨 Pre-configured VSCode integration

## Requirements

- PHP 8.1 or higher
- Composer

## Installation

Install via composer as a development dependency:

```bash
composer require huangdijia/php-coding-standard --dev
```

## Quick Start

### Option 1: Use the provided stub file

Copy the configuration stub to your project root:

```bash
cp vendor/huangdijia/php-coding-standard/.php-cs-fixer.php.stub .php-cs-fixer.php
```

Edit the copied `.php-cs-fixer.php` file to match your project details:

```php
<?php

use Huangdijia\PhpCsFixer\Config;
use PhpCsFixer\Runner\Parallel\ParallelConfig;

require __DIR__ . '/vendor/autoload.php';

return (new Config())
    ->setParallelConfig(new ParallelConfig(4, 20))
    ->setHeaderComment(
        projectName: 'your-vendor/your-package',
        projectLink: 'https://github.com/your-vendor/your-package',
        projectDocument: 'https://github.com/your-vendor/your-package/blob/main/README.md',
        contacts: [
            'Your Name' => 'your-email@example.com',
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

### Option 2: Replace existing php-cs-fixer

If you already have `friendsofphp/php-cs-fixer` in your project:

```bash
composer remove friendsofphp/php-cs-fixer --dev --no-update
composer require huangdijia/php-coding-standard --dev --no-update
composer update -o
cp vendor/huangdijia/php-coding-standard/.php-cs-fixer.php.stub .php-cs-fixer.php
```

## Usage

### Basic Commands

Fix code style issues:

```bash
vendor/bin/php-cs-fixer fix
```

Dry run (preview changes without applying):

```bash
vendor/bin/php-cs-fixer fix --dry-run --diff
```

If you have the composer script configured:

```bash
composer cs-fix
composer cs-fix -- --dry-run --diff
```

### Advanced Configuration

#### Custom Rules

You can add or override rules using the fluent API:

```php
return (new Config())
    ->setHeaderComment(/* ... */)
    ->addRules([
        'strict_comparison' => true,
        'native_function_invocation' => ['include' => ['@all']],
    ])
    ->setRule('yoda_style', false)
    ->setFinder(/* ... */);
```

#### Available Methods

- `setRule(string $rule, mixed $value)`: Set a single rule
- `addRules(array $rules)`: Add multiple rules (merges with existing)
- `setHeaderComment(...)`: Configure automatic header comments

#### Header Comment Configuration

The `setHeaderComment` method supports flexible contact formats:

```php
// Array with name => email pairs
->setHeaderComment(
    projectName: 'my-project',
    contacts: [
        'John Doe' => 'john@example.com',
        'Jane Smith' => 'jane@example.com',
    ]
)

// Simple array of email addresses
->setHeaderComment(
    projectName: 'my-project', 
    contacts: ['john@example.com', 'jane@example.com']
)
```

#### Excluding Directories

Customize which directories to scan:

```php
->setFinder(
    PhpCsFixer\Finder::create()
        ->exclude('bootstrap')
        ->exclude('storage')
        ->exclude('vendor')
        ->exclude('node_modules')
        ->in(__DIR__)
        ->name('*.php')
        ->notPath('database/migrations')
)
```

## Integration

### VSCode

The package includes optimized VSCode settings. Copy the configuration:

```bash
mkdir -p .vscode
cp vendor/huangdijia/php-coding-standard/.vscode/* .vscode/
```

### CI/CD

Example GitHub Actions workflow:

```yaml
name: Code Style

on: [push, pull_request]

jobs:
  php-cs-fixer:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
      - run: composer install
      - run: vendor/bin/php-cs-fixer fix --dry-run --diff
```

### Pre-commit Hook

Add to `.git/hooks/pre-commit`:

```bash
#!/bin/sh
vendor/bin/php-cs-fixer fix --dry-run --diff --diff-format=udiff
```

## Included Rules

This configuration includes:

- **PSR-2**: Basic coding standards
- **Symfony**: Symfony coding standards
- **PhpCsFixer**: Additional modern PHP best practices
- **DoctrineAnnotation**: Doctrine annotation formatting
- **Custom optimizations**: Performance and readability improvements

Key customizations:
- Short array syntax (`[]` instead of `array()`)
- Single quotes for strings
- Optimized import ordering
- Proper PHPDoc formatting
- Strict type declarations
- Modern PHP 8.1+ features

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

Please ensure all code follows the established coding standards by running:

```bash
composer cs-fix
composer json-fix
```

## Security

If you discover any security vulnerabilities, please email [huangdijia@gmail.com](mailto:huangdijia@gmail.com) instead of using the issue tracker.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
