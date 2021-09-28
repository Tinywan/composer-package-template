<?php

declare(strict_types=1);

namespace Tinywan\Template\Contract;

interface ConfigInterface
{
    /**
     * @param mixed $default default value of the entry when does not found
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param mixed $value
     */
    public function set(string $key, $value);
}