<?php

declare(strict_types=1);

namespace Tinywan\Template\Service;

use GuzzleHttp\Client;
use Tinywan\Template\App;
use Tinywan\Template\Contract\ConfigInterface;
use Tinywan\Template\Contract\HttpClientInterface;
use Tinywan\Template\Contract\ServiceProviderInterface;

class HttpServiceProvider implements ServiceProviderInterface
{
    public function register(App $app, ?array $data = null): void
    {
        /* @var \Yansongda\Supports\Config $config */
        $config = App::get(ConfigInterface::class);

        $service = new Client($config->get('http', []));

        App::set(HttpClientInterface::class, $service);
    }
}