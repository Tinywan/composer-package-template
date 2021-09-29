<?php

declare(strict_types=1);

namespace Tinywan\Template\Service;

use Tinywan\Template\App;
use Tinywan\Template\Contract\ConfigInterface;
use Tinywan\Template\Contract\ServiceProviderInterface;
use Tinywan\Template\Exception\ContainerException;
use Yansongda\Supports\Config;

class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * @var array
     */
    private $config = [
        'logger' => [
            'enable' => false,
            'file' => null,
            'identify' => 'yansongda.pay',
            'level' => 'debug',
            'type' => 'daily',
            'max_files' => 30,
        ],
        'http' => [
            'timeout' => 5.0,
            'connect_timeout' => 3.0,
        ],
    ];

    /**
     * @throws ContainerException
     */
    public function register(App $app, ?array $data = null): void
    {
        $config = new Config(array_replace_recursive($this->config, $data ?? []));

        App::set(ConfigInterface::class, $config);
        App::set('config', $config);
    }
}
