<?php

declare(strict_types=1);

use Yansongda\Supports\Config;
use Yansongda\Supports\Str;

if (!function_exists('get_alipay_config')) {
    /**
     * @throws \Tinywan\Template\Exception\ContainerDependencyException
     * @throws \Tinywan\Template\Exception\ContainerException
     * @throws \Tinywan\Template\Exception\ServiceNotFoundException
     */
    function get_alipay_config(array $params = []): Config
    {
        $alipay = \Tinywan\Template\App::get(\Tinywan\Template\Contract\ConfigInterface::class)->get('alipay');

        $config = $params['_config'] ?? 'default';

        return new Config($alipay[$config] ?? []);
    }
}

if (!function_exists('get_public_or_private_cert')) {
    /**
     * @param bool $publicKey 是否公钥
     *
     * @return resource|string
     */
    function get_public_or_private_cert(string $key, bool $publicKey = false)
    {
        if ($publicKey) {
            return Str::endsWith($key, ['.cer', '.crt', '.pem']) ? file_get_contents($key) : $key;
        }

        if (Str::endsWith($key, ['.crt', '.pem'])) {
            return openssl_pkey_get_private(
                Str::startsWith($key, 'file://') ? $key : 'file://'.$key
            );
        }

        return "-----BEGIN RSA PRIVATE KEY-----\n".
            wordwrap($key, 64, "\n", true).
            "\n-----END RSA PRIVATE KEY-----";
    }
}
