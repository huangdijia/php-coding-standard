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
    ->setParallelConfig(new ParallelConfig(4, 20))
    ->setHeaderComment(
        projectName: 'my-company/laravel-project',
        projectLink: 'https://github.com/my-company/laravel-project',
        projectDocument: 'https://github.com/my-company/laravel-project/blob/main/README.md',
        contacts: [
            'Developer Team' => 'dev@company.com',
        ],
    )
    ->forLaravel() // Apply Laravel-specific optimizations
    ->enableCache() // Enable caching for better performance
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('bootstrap/cache')
            ->exclude('storage')
            ->exclude('vendor')
            ->exclude('node_modules')
            ->in(__DIR__)
            ->name('*.php')
            ->notPath('database/migrations') // Skip migrations as they have specific formatting
    );
