<?php

declare(strict_types=1);

namespace App\ViewMapper\Model;

use LogicException;
use function get_class;
use function is_object;
use function gettype;
use function sprintf;

abstract class AbstractView
{
//    private function __construct($entity)
//    {
//        $type = is_object($entity) ? get_class($entity) : gettype($entity);
//        throw new LogicException(sprintf('You must create child constructor with argument of type "%s".', $type));
//    }

    /** @return static[] */
    public static function fromIterable(iterable $entities): array
    {
        $views = [];
        foreach ($entities as $entity) {
            $views[] = new static($entity);
        }

        return $views;
    }

    /**  @return ViewIterator|static[] */
    public static function lazy(callable $dataProvider): ViewIterator
    {
        $viewBuilder = function ($entity) {
            return new static($entity);
        };

        return new ViewIterator($dataProvider, $viewBuilder);
    }
}
