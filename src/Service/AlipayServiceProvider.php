<?php

declare(strict_types=1);

namespace Tinywan\Template\Service;

use Tinywan\Template\App;
use Tinywan\Template\Contract\ParserInterface;
use Tinywan\Template\Contract\ServiceProviderInterface;
use Tinywan\Template\Parser\CollectionParser;
use Tinywan\Template\Provider\Alipay;

class AlipayServiceProvider implements ServiceProviderInterface
{
    public function register(App $app, ?array $data = null): void
    {
        $service = function () {
            App::set(ParserInterface::class, CollectionParser::class);
            return new Alipay();
        };

        $app::set(Alipay::class, $service);
        $app::set('alipay', $service);
    }
}