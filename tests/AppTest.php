<?php

namespace Tinywan\Template\Tests;


use Tinywan\Template\App;
use Tinywan\Template\Contract\ConfigInterface;

class AppTest extends TestCase
{
    protected function setUp(): void
    {
        App::clear();
    }

    protected function tearDown(): void
    {
        App::clear();
    }

    public function testConfig()
    {
        $result = App::config(['name' => 'yansongda']);
        self::assertInstanceOf(App::class, $result);
         self::assertEquals('yansongda', App::get(ConfigInterface::class)->get('name'));
    }
}