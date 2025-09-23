<?php
declare(strict_types=1);
/**
 * This file is part of huangdijia/php-coding-standard.
 *
 * @link     https://github.com/huangdijia/php-coding-standard
 * @document https://github.com/huangdijia/php-coding-standard/blob/main/README.md
 * @contact  Deeka Wong <huangdijia@gmail.com>
 */
use Huangdijia\PhpCsFixer\Config;
use PhpCsFixer\Runner\Parallel\ParallelConfig;

require __DIR__ . '/vendor/autoload.php';

return (new Config())
    ->setParallelConfig(new ParallelConfig(2, 10)) // Smaller parallel config for libraries
    ->setHeaderComment(
        projectName: 'vendor/package-name',
        projectLink: 'https://github.com/vendor/package-name',
        projectDocument: 'https://github.com/vendor/package-name/blob/main/README.md',
        contacts: [
            'Package Maintainer' => 'maintainer@example.com',
        ],
    )
    ->disableRiskyRules() // Use safer rules for library code
    ->enableCache('.php-cs-fixer.cache') // Enable caching
    ->addRules([
        // Additional strict rules for libraries
        'strict_comparison' => true,
        'strict_param' => true,
        'native_function_invocation' => [
            'include' => ['@all'],
            'scope' => 'namespaced',
            'strict' => true,
        ],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->exclude('build')
            ->exclude('tests/fixtures')
            ->in(__DIR__)
            ->name('*.php')
    );
