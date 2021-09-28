<?php

/**
 * @desc ServiceNotFoundException
 * @author Tinywan(ShaoBo Wan)
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
     * @param mixed $extra
     */
    public function __construct(string $message = 'Service Not Found', int $code = self::SERVICE_NOT_FOUND_ERROR, $extra = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $extra, $previous);
    }
}