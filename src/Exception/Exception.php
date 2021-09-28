<?php

/**
 * @desc Exception
 */

declare(strict_types=1);

namespace Tinywan\Template\Exception;

use Throwable;

class Exception extends \Exception
{
    /*
     * 关于配置.
     */
    public const CONFIG_ERROR = 3000;

    public const SERVICE_NOT_FOUND_ERROR = 5000;

    /**
     * raw.
     *
     * @var mixed
     */
    public $extra = null;

    /**
     * Bootstrap.
     *
     * @param mixed $extra
     */
    public function __construct(string $message = 'Unknown Error', int $code = self::UNKNOWN_ERROR, $extra = null, Throwable $previous = null)
    {
        $this->extra = $extra;

        parent::__construct($message, $code, $previous);
    }
}
