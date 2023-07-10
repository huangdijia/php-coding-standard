<?php

declare(strict_types=1);
/**
 * This file is part of huangdijia/php-coding-standard.
 *
 * @link     https://github.com/huangdijia/php-coding-standard
 * @document https://github.com/huangdijia/php-coding-standard/blob/main/README.md
 * @contact  Deeka Wong <huangdijia@gmail.com>
 */
namespace Huangdijia\PhpCsFixer;

/**
 * Determine if the given value is a list of items.
 * @return bool return true if the array keys are 0 .. count($array)-1 in that order. For other arrays, it returns false. For non-arrays, it throws a TypeError.
 */
function array_is_list(array $array): bool
{
    if ($array === [] || $array === array_values($array)) {
        return true;
    }
    $nextKey = -1;
    foreach ($array as $k => $v) {
        if ($k !== ++$nextKey) {
            return false;
        }
    }
    return true;
}
