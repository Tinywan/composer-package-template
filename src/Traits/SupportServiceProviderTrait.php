<?php
/**
 * @desc SupportServiceProviderTrait.php 描述信息
 * @date 2021/9/29 16:34
 */

declare(strict_types=1);

namespace Tinywan\Template\Traits;

use Tinywan\Template\App;
use Tinywan\Template\Rocket;

trait SupportServiceProviderTrait
{
    protected function loadServiceProvider(Rocket $rocket): void
    {
        $params = $rocket->getParams();
        $config = get_alipay_config($params);
        $serviceProviderId = $config->get('service_provider_id');

        if (App::MODE_SERVICE !== $config->get('mode', App::MODE_NORMAL) ||
            empty($serviceProviderId)) {
            return;
        }

        $rocket->mergeParams([
            'extend_params' => array_merge($params['extend_params'] ?? [], ['sys_service_provider_id' => $serviceProviderId]),
        ]);
    }
}
