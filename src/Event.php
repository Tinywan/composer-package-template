<?php

declare(strict_types=1);

namespace Tinywan\Template;

use Tinywan\Template\Contract\EventDispatcherInterface;
use Tinywan\Template\Exception\InvalidConfigException;

class Event
{
    public static function __callStatic(string $method, array $args): void
    {
        if (!App::hasContainer() || !App::has(EventDispatcherInterface::class)) {
            return;
        }

        $class = App::get(EventDispatcherInterface::class);

        if ($class instanceof \Psr\EventDispatcher\EventDispatcherInterface) {
            $class->{$method}(...$args);

            return;
        }

        throw new InvalidConfigException(Exception\Exception::EVENT_CONFIG_ERROR);
    }
}
