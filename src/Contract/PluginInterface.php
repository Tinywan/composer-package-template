<?php
/**
 * @desc PluginInterface.php 得益于 pipeline，所有数据变换都通过 plugin 来实现
 * @date 2021/9/29 15:28
 */

declare(strict_types=1);

namespace Tinywan\Template\Contract;

use Tinywan\Template\Rocket;

interface PluginInterface
{
    /**
     * @desc: 组装(assembly) 一系列支付要求的参数 ，中间件的入口执行方法必须是assembly方法，而且第一个参数是Rocket对象，第二个参数是一个闭包
     * @param Rocket $rocket
     * @param \Closure $next
     * @return Rocket
     * @author Tinywan(ShaoBo Wan)
     */
    public function assembly(Rocket $rocket, \Closure $next): Rocket;
}
