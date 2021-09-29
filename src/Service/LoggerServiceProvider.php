<?php

declare(strict_types=1);

namespace Tinywan\Template\Service;

use Tinywan\Template\App;
use Tinywan\Template\Contract\ConfigInterface;
use Tinywan\Template\Contract\LoggerInterface;
use Tinywan\Template\Contract\ServiceProviderInterface;
use Yansongda\Supports\Logger;

class LoggerServiceProvider implements ServiceProviderInterface
{
    public function register(App $app, ?array $data = null): void
    {
        /* @var ConfigInterface $config */
        $config = App::get(ConfigInterface::class);

        if (class_exists(\Monolog\Logger::class) && true === $config->get('logger.enable', false)) {
            $logger = new Logger(array_merge(
                ['identify' => 'yansongda.pay'], $config->get('logger', [])
            ));

            App::set(LoggerInterface::class, $logger);
        }
    }
}
