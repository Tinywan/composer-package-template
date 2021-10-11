<?php
/**
 * @desc FunctionTest.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 10:31
 */


namespace Tinywan\Template\Tests;


use Tinywan\Template\App;

class FunctionTest extends TestCase
{
    public function testGetAlipayConfig()
    {
        self::assertArrayHasKey('app_id', get_alipay_config([])->all());

        App::clear();

        $config2 = [
            'alipay' => [
                'default' => ['name' => 'yansongda'],
                'c1' => ['age' => 28]
            ]
        ];
        App::config($config2);
        self::assertEquals(['name' => 'yansongda'], get_alipay_config([])->all());

        self::assertEquals(['age' => 28], get_alipay_config(['_config' => 'c1'])->all());
    }
}