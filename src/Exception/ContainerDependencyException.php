<?php

declare(strict_types=1);

namespace Tinywan\Template\Exception;

use Throwable;

class ContainerDependencyException extends ContainerException
{
    /**
     * Bootstrap.
     *
     * @param string $message
     * @param int $code
     * @param mixed $extra
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = 'Dependency Resolve Error',
        int $code = self::CONTAINER_DEPENDENCY_ERROR,
        $extra = null,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $extra, $previous);
    }
}
