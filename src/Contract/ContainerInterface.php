<?php

declare(strict_types=1);

namespace Tinywan\Template\Contract;

use DI\FactoryInterface;
use Invoker\InvokerInterface;

interface ContainerInterface extends \Psr\Container\ContainerInterface, FactoryInterface, InvokerInterface
{
}
