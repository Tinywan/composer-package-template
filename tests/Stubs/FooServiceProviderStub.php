<?php
/**
 * @desc FooServiceProviderStub.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/9/29 9:40
 */

namespace Tinywan\Template\Tests\Stubs;


use Tinywan\Template\App;
use Tinywan\Template\Contract\ServiceProviderInterface;
use Tinywan\Template\Exception\ContainerException;

class FooServiceProviderStub implements ServiceProviderInterface
{
    /**
     * @param App $app
     * @param array|null $data
     * @throws ContainerException
     * @author Tinywan(ShaoBo Wan)
     */
    public function register(App $app, ?array $data = null): void
    {
        $app::set('foo', 'bar');
    }
}