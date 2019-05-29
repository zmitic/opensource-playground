<?php

declare(strict_types=1);

namespace App\ViewMapper;

use function array_map;

abstract class AbstractViewMapper
{
    abstract public static function single($object): array;

    public static function multiple(array $objects): array
    {
        return array_map([static::class, 'single'], $objects);
    }
}
