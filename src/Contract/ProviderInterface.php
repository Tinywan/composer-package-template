<?php

declare(strict_types=1);

namespace Tinywan\Template\Contract;

use Yansongda\Supports\Collection;

interface ProviderInterface
{
    /**
     * Quick road - Query an order.
     *
     * @param string|array $order
     *
     * @return array|Collection
     */
    public function find($order);
}
