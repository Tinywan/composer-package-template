<?php

declare(strict_types=1);

namespace Tinywan\Template\Exception;

use Throwable;

class ContainerNotFoundException extends ContainerException
{
    /**
     * Bootstrap.
     *
     * @param string $message
     * @param int $code
     * @param mixed $extra
     * @param Throwable|null $previous
     */
    public function __construct(string $message = 'Container Not Found', int $code = self::CONTAINER_NOT_FOUND, $extra = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $extra, $previous);
    }
}
