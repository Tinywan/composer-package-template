<?php

/**
 * @desc InvalidConfigException
 * @author Tinywan(ShaoBo Wan)
 */

declare(strict_types=1);

namespace Tinywan\Template\Exception;

use Throwable;

class InvalidConfigException extends Exception
{
    /**
     * Bootstrap.
     *
     * @param mixed $extra
     */
    public function __construct(int $code = self::CONFIG_ERROR, string $message = 'Config Error', $extra = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $extra, $previous);
    }
}