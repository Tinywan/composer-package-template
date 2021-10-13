<?php
/**
 * @desc GeneralPlugin 常用插件
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 11:32
 */

declare(strict_types=1);

namespace Tinywan\Template\Plugin\Alipay;


use Tinywan\Template\Contract\PluginInterface;
use Tinywan\Template\Logger;
use Tinywan\Template\Rocket;

abstract class GeneralPlugin implements PluginInterface
{
    public function assembly(Rocket $rocket, \Closure $next): Rocket
    {
        Logger::info('[alipay][GeneralPlugin] 通用插件开始装载', ['rocket' => $rocket]);

        $rocket->mergePayload([
            'method' => $this->getMethod(),
            'biz_content' => $rocket->getParams(),
        ]);

        Logger::info('[alipay][GeneralPlugin] 通用插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }

    abstract protected function getMethod(): string;
}