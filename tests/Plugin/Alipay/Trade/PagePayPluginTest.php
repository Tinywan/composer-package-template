<?php
/**
 * @desc PagePayPluginTest.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/9/29 16:27
 */


namespace Tinywan\Template\Tests\Plugin\Alipay\Trade;


use Tinywan\Template\Parser\ResponseParser;
use Tinywan\Template\Plugin\Alipay\Trade\PagePayPlugin;
use Tinywan\Template\Rocket;
use Tinywan\Template\Tests\TestCase;

class PagePayPluginTest extends TestCase
{
    /**
     * @desc: 标准化测试
     * @author Tinywan(ShaoBo Wan)
     */
    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([]);

        $plugin = new PagePayPlugin();

        $result = $plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertEquals(ResponseParser::class, $result->getDirection());
        self::assertStringContainsString('alipay.trade.page.pay', $result->getPayload()->toJson());
        self::assertStringContainsString('FAST_INSTANT_TRADE_PAY', $result->getPayload()->toJson());
    }
}