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
    ->setHeaderComment(
        projectName: 'huangdijia/php-coding-standard',
        projectLink: 'https://github.com/huangdijia/php-coding-standard',
        projectDocument: 'https://github.com/huangdijia/php-coding-standard/blob/main/README.md',
        contacts: [
            'Deeka Wong' => 'huangdijia@gmail.com',
        ],
    )
    ->setParallelConfig(new ParallelConfig(4, 20))
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
