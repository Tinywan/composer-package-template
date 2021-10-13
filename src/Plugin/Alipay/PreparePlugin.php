<?php
/**
 * @desc PreparePlugin.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 11:26
 */


namespace Tinywan\Template\Plugin\Alipay;


use Tinywan\Template\Contract\PluginInterface;
use Tinywan\Template\Exception\Exception;
use Tinywan\Template\Exception\InvalidConfigException;
use Tinywan\Template\Logger;
use Tinywan\Template\Rocket;

class PreparePlugin implements PluginInterface
{
    /**
     * @desc: 方法描述
     * @param Rocket $rocket
     * @param \Closure $next
     * @return Rocket
     * @author Tinywan(ShaoBo Wan)
     */
    public function assembly(Rocket $rocket, \Closure $next): Rocket
    {
        Logger::info('[alipay][PreparePlugin] 插件开始装载', ['rocket' => $rocket]);

        $rocket->mergePayload($this->getPayload($rocket->getParams()));

        Logger::info('[alipay][PreparePlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }

    /**
     * @desc: 获取请求载体
     * @param array $params
     * @return array
     */
    protected function getPayload(array $params): array
    {
        return [
            'app_id' => get_alipay_config($params)->get('app_id', ''),
            'method' => '',
            'format' => 'JSON',
            'return_url' => $this->getReturnUrl($params),
            'charset' => 'utf-8',
            'sign_type' => 'RSA2',
            'sign' => '',
            'timestamp' => date('Y-m-d H:i:s'),
            'version' => '1.0',
            'notify_url' => $this->getNotifyUrl($params),
            'app_auth_token' => '',
            'app_cert_sn' => $this->getAppCertSn($params),
            'alipay_root_cert_sn' => $this->getAlipayRootCertSn($params),
            'biz_content' => [],
        ];
    }

    /**
     * @desc: 获取同步URL地址
     * @param array $params
     * @return string
     */
    protected function getReturnUrl(array $params): string
    {
        if (!empty($params['_return_url'])) {
            return $params['_return_url'];
        }

        return get_alipay_config($params)->get('return_url', '');
    }

    protected function getNotifyUrl(array $params): string
    {
        if (!empty($params['_notify_url'])) {
            return $params['_notify_url'];
        }

        return get_alipay_config($params)->get('notify_url', '');
    }

    protected function getAppCertSn(array $params): string
    {
        $path = get_alipay_config($params)->get('app_public_cert_path');

        if (is_null($path)) {
            throw new InvalidConfigException(Exception::ALIPAY_CONFIG_ERROR, 'Missing Alipay Config -- [app_public_cert_path]');
        }

        $cert = file_get_contents($path);
        $ssl = openssl_x509_parse($cert);

        return $this->getCertSn($ssl['issuer'], $ssl['serialNumber']);
    }

    protected function getCertSn(array $issuer, string $serialNumber): string
    {
        return md5(
            $this->array2string(array_reverse($issuer)).$serialNumber
        );
    }

    protected function array2string(array $array): string
    {
        $string = [];

        foreach ($array as $key => $value) {
            $string[] = $key.'='.$value;
        }

        return implode(',', $string);
    }
}