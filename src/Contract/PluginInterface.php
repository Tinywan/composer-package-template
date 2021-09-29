<?php
/**
 * @desc PluginInterface.php 描述信息
 * @date 2021/9/29 15:28
 */

declare(strict_types=1);

namespace Tinywan\Template\Contract;

use Tinywan\Template\Rocket;

interface PluginInterface
{
    // 中间件的入口执行方法必须是assembly方法，而且第一个参数是Rocket对象，第二个参数是一个闭包
    public function assembly(Rocket $rocket, \Closure $next): Rocket;
}
