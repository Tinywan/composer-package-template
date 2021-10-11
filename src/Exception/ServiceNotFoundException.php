<?php

/**
 * @desc ServiceNotFoundException
 */

declare(strict_types=1);

namespace Tinywan\Template\Exception;

use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class ServiceNotFoundException extends Exception implements NotFoundExceptionInterface
{
    /**
     * Bootstrap.
     *
     * @param string $message
     * @param int $code
     * @param mixed $extra
     * @param Throwable|null $previous
     */
    public function __construct(string $message = 'Service Not Found', int $code = self::SERVICE_NOT_FOUND_ERROR, $extra = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $extra, $previous);
    }
}
