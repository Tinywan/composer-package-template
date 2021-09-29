<?php
/**
 * @desc ParserPluginTest.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/9/29 15:38
 */


namespace Tinywan\Template\Tests\Plugin;


use Tinywan\Template\Exception\InvalidConfigException;
use Tinywan\Template\Plugin\ParserPlugin;
use Tinywan\Template\Rocket;
use Tinywan\Template\Tests\Stubs\FooPackerStub;
use Tinywan\Template\Tests\TestCase;

class ParserPluginTest extends TestCase
{
    public function testPackerWrong()
    {
        self::expectException(InvalidConfigException::class);
        self::expectExceptionCode(InvalidConfigException::INVALID_PACKER);

        // 火箭HTTP请求
        $rocket = new Rocket();
        $rocket->setDirection(FooPackerStub::class);

        // 解析器插件
        $parser = new ParserPlugin();
        $parser->assembly($rocket, function ($rocket) { return $rocket; });
    }
}