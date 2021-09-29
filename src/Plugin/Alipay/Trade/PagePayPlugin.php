<?php
/**
 * @desc PagePayPlugin.php 描述信息
 * @date 2021/9/29 16:30
 */

declare(strict_types=1);

namespace Tinywan\Template\Plugin\Alipay\Trade;

use Tinywan\Template\Contract\PluginInterface;
use Tinywan\Template\Logger;
use Tinywan\Template\Parser\ResponseParser;
use Tinywan\Template\Rocket;
use Tinywan\Template\Traits\SupportServiceProviderTrait;

class PagePayPlugin implements PluginInterface
{
    use SupportServiceProviderTrait;

    public function assembly(Rocket $rocket, \Closure $next): Rocket
    {
        Logger::info('[alipay][PagePayPlugin] 插件开始装载', ['rocket' => $rocket]);

        $this->loadServiceProvider($rocket);

        $rocket->setDirection(ResponseParser::class)
            ->mergePayload([
                'method' => 'alipay.trade.page.pay',
                'biz_content' => array_merge(
                    ['product_code' => 'FAST_INSTANT_TRADE_PAY'],
                    $rocket->getParams()
                ),
            ]);

        Logger::info('[alipay][PagePayPlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }
}
