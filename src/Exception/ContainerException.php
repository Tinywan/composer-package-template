<?php

declare(strict_types=1);

namespace Tinywan\Template\Exception;

use Psr\Container\ContainerExceptionInterface;
use Throwable;

class ContainerException extends Exception implements ContainerExceptionInterface
{
    /**
     * Bootstrap.
     *
     * @param mixed $extra
     */
    public function __construct(string $message = 'Container Not Found', int $code = self::CONTAINER_NOT_FOUND, $extra = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $extra, $previous);
    }
}
