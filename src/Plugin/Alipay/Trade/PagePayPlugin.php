<?php
/**
 * @desc 组装参数 Plugin
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

    /**
     * @desc: 这个 Plugin 的目的就是为了组装一系列支付宝所需要的参数
     * @param Rocket $rocket
     * @param \Closure $next
     * @return Rocket
     * @author Tinywan(ShaoBo Wan)
     */
    public function assembly(Rocket $rocket, \Closure $next): Rocket
    {
        Logger::info('[alipay][PagePayPlugin] 插件开始装载', ['rocket' => $rocket]);

        $this->loadServiceProvider($rocket);

        // 由于电脑支付是不需要后端 http 调用支付宝接口的， 只需要一个浏览器的响应，所以，我们把 🚀 的 Direction 设置成了 ResponseParser::class。
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
