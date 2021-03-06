<?php
/**
 * @desc SignPlugin.php 描述信息
 * @date 2021/9/29 15:32
 */

declare(strict_types=1);

namespace Tinywan\Template\Plugin\Alipay;

use Tinywan\Template\Contract\PluginInterface;
use Tinywan\Template\Exception\ContainerDependencyException;
use Tinywan\Template\Exception\ContainerException;
use Tinywan\Template\Exception\Exception;
use Tinywan\Template\Exception\InvalidConfigException;
use Tinywan\Template\Exception\ServiceNotFoundException;
use Tinywan\Template\Logger;
use Tinywan\Template\Rocket;
use Yansongda\Supports\Str;

class SignPlugin implements PluginInterface
{
    /**
     * @desc: 装配
     * @param Rocket $rocket
     * @param \Closure $next
     * @return Rocket
     */
    public function assembly(Rocket $rocket, \Closure $next): Rocket
    {
        Logger::info('[alipay][SignPlugin] 插件开始装载', ['rocket' => $rocket]);

        $this->formatPayload($rocket);

        $sign = $this->getSign($rocket);

        $rocket->mergePayload(['sign' => $sign]);

        Logger::info('[alipay][SignPlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }

    /**
     * @desc: 格式有效载荷
     */
    protected function formatPayload(Rocket $rocket): void
    {
        $payload = $rocket->getPayload()->filter(function ($v, $k) {
            return '' !== $v && !is_null($v) && 'sign' != $k;
        });

        $contents = array_filter($payload->get('biz_content', []), function ($v, $k) {
            return !Str::startsWith(strval($k), '_');
        }, ARRAY_FILTER_USE_BOTH);

        $rocket->setPayload(
            $payload->merge(['biz_content' => json_encode($contents)])
        );
    }

    /**
     * @desc: 获取签名
     * @param Rocket $rocket
     * @return string
     * @throws InvalidConfigException
     * @throws ContainerDependencyException
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    protected function getSign(Rocket $rocket): string
    {
        $privateKey = $this->getPrivateKey($rocket->getParams());

        $content = $rocket->getPayload()->sortKeys()->toString();

        openssl_sign($content, $sign, $privateKey, OPENSSL_ALGO_SHA256);

        $sign = base64_encode($sign);

        !is_resource($privateKey) ?: openssl_free_key($privateKey);

        return $sign;
    }

    /**
     * @desc: 方法描述
     * @param array $params
     * @return resource|string
     * @throws InvalidConfigException
     * @throws ContainerDependencyException
     * @throws ContainerException
     * @throws ServiceNotFoundException
     * @author Tinywan(ShaoBo Wan)
     */
    protected function getPrivateKey(array $params)
    {
        $privateKey = get_alipay_config($params)->get('app_secret_cert');

        if (is_null($privateKey)) {
            throw new InvalidConfigException(Exception::ALIPAY_CONFIG_ERROR, 'Missing Alipay Config -- [app_secret_cert]');
        }

        return get_public_or_private_cert($privateKey);
    }
}
