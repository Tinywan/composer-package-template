<?php

declare(strict_types=1);

namespace Tinywan\Template\Service;

use Tinywan\Template\Contract\ConfigInterface;
use Tinywan\Template\Contract\LoggerInterface;
use Yansongda\Supports\Logger;

class LoggerServiceProvider
{
    public function register(Pay $pay, ?array $data = null): void
    {
        /* @var ConfigInterface $config */
        $config = Pay::get(ConfigInterface::class);

        if (class_exists(\Monolog\Logger::class) && true === $config->get('logger.enable', false)) {
            $logger = new Logger(array_merge(
                ['identify' => 'yansongda.pay'], $config->get('logger', [])
            ));

            Pay::set(LoggerInterface::class, $logger);
        }
    }
}