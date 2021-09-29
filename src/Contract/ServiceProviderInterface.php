<?php

declare(strict_types=1);

namespace Tinywan\Template\Contract;

use Tinywan\Template\App;

interface ServiceProviderInterface
{
    /**
     * register the service.
     */
    public function register(App $app, ?array $data = null): void;
}
