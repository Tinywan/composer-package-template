<?php
/**
 * @desc GeneralPlugin.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 11:35
 */


namespace Tinywan\Template\Plugin\Wechat;


use Psr\Http\Message\RequestInterface;
use Tinywan\Template\Contract\PluginInterface;
use Tinywan\Template\Logger;
use Tinywan\Template\Rocket;

class GeneralPlugin implements PluginInterface
{
    public function assembly(Rocket $rocket, \Closure $next): Rocket
    {
        Logger::info('[wechat][GeneralPlugin] 通用插件开始装载', ['rocket' => $rocket]);

        $rocket->setRadar($this->getRequest($rocket));
        $this->doSomething($rocket);

        Logger::info('[wechat][GeneralPlugin] 通用插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }

    protected function getRequest(Rocket $rocket): RequestInterface
    {
        return new Request(
            $this->getMethod(),
            $this->getUrl($rocket),
            $this->getHeaders(),
        );
    }

    protected function getMethod(): string
    {
        return 'POST';
    }

    protected function getUrl(Rocket $rocket): string
    {
        $params = $rocket->getParams();
        $mode = get_wechat_config($params)->get('mode');

        return get_wechat_base_uri($params).
            (Pay::MODE_SERVICE == $mode ? $this->getPartnerUri($rocket) : $this->getUri($rocket));
    }

    protected function getHeaders(): array
    {
        return [
            'Accept' => 'application/json, text/plain, application/x-gzip',
            'User-Agent' => 'yansongda/pay-v3.0',
            'Content-Type' => 'application/json; charset=utf-8',
        ];
    }

    abstract protected function doSomething(Rocket $rocket): void;

    abstract protected function getUri(Rocket $rocket): string;

    protected function getPartnerUri(Rocket $rocket): string
    {
        return $this->getUri($rocket);
    }
}