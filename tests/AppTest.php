<?php

namespace Tinywan\Template\Tests;


use DI\Container;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Tinywan\Template\App;
use Tinywan\Template\Contract\ConfigInterface;
use Tinywan\Template\Contract\EventDispatcherInterface;
use Tinywan\Template\Contract\HttpClientInterface;
use Tinywan\Template\Contract\LoggerInterface;
use Tinywan\Template\Exception\ContainerException;
use Tinywan\Template\Tests\Stubs\FooServiceProviderStub;
use Yansongda\Supports\Config;
use Yansongda\Supports\Logger;
use Yansongda\Supports\Pipeline;

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
        $result = App::config(['name' => 'template']);
        self::assertInstanceOf(App::class, $result);
        self::assertEquals('template', App::get(ConfigInterface::class)->get('name'));

        // force
        $result1 = App::config(['name' => 'tinywan2', '_force' => true]);
        self::assertInstanceOf(App::class, $result1);
        self::assertEquals('tinywan2', App::get(ConfigInterface::class)->get('name'));
    }

    public function testSetAndGet()
    {
        App::config(['name' => 'template']);

        App::set('age', 28);

        self::assertEquals(28, App::get('age'));
    }

    public function testHas()
    {
        App::config(['name' => 'template']);

        App::set('age', 28);

        self::assertFalse(App::has('name'));
        self::assertTrue(App::has('age'));
    }

    public function testGetContainerAndClear()
    {
        App::config(['name' => 'template']);
        self::assertInstanceOf(ContainerInterface::class, App::getContainer());

        App::clear();

        $this->expectException(ContainerException::class);
        $this->expectExceptionCode(ContainerException::CONTAINER_NOT_FOUND);
        $this->expectExceptionMessage('You should init/config App first');

        App::getContainer();
    }

    public function testMakeService()
    {
        App::config(['name' => 'template']);
        self::assertNotSame(App::make(Pipeline::class), App::make(Pipeline::class));
    }

    public function testRegisterService()
    {
        App::config(['name' => 'template']);

        App::registerService(FooServiceProviderStub::class, []);

        self::assertEquals('bar', App::get('foo'));
    }

    public function testKernelService()
    {
        App::config(['name' => 'template']);
        // assertInstanceOf($expected, $actual[, $message = '']) 当 $actual 不是 $expected 的实例时报告错误，错误讯息由 $message 指定。
        // self::assertInstanceOf(Container::class, App::get(\Tinywan\Template\Contract\ContainerInterface::class));
        self::assertInstanceOf(Container::class, App::get(ContainerInterface::class));
        self::assertInstanceOf(App::class, App::get(App::class));
    }

    public function testKernelServiceConfig()
    {
        $config = ['name' => 'template'];
        App::config($config);

        self::assertInstanceOf(Config::class, App::get(ConfigInterface::class));
        self::assertInstanceOf(Config::class, App::get('config'));
        self::assertEquals($config['name'], App::get(ConfigInterface::class)->get('name'));

        // 修改 config 的情况
        $config2 = [
            'name' => 'template-2',
        ];
        App::set(ConfigInterface::class, new Config($config2));

        self::assertEquals($config2['name'], App::get(ConfigInterface::class)->get('name'));
    }

    public function testKernelServiceLogger()
    {
        $config = ['name' => 'yansongda','logger' => ['enable' => true]];
        App::config($config);

        self::assertInstanceOf(Logger::class, App::get(LoggerInterface::class));

        $otherLogger = new \Monolog\Logger('test');
        App::set(LoggerInterface::class, $otherLogger);
        self::assertEquals($otherLogger, App::get(LoggerInterface::class));
    }

    public function testKernelServiceEvent()
    {
        $config = ['name' => 'yansongda'];
        App::config($config);

        self::assertInstanceOf(EventDispatcher::class, App::get(EventDispatcherInterface::class));
    }

    public function testKernelServiceHttpClient()
    {
        $config = ['name' => 'template'];
        App::config($config);

        self::assertInstanceOf(Client::class, App::get(HttpClientInterface::class));

        // 使用外部 http client
        $oldClient = App::get(HttpClientInterface::class);

        $client = new Client(['timeout' => 3.0]);
        App::set(HttpClientInterface::class, $client);

        self::assertEquals($client, App::get(HttpClientInterface::class));
        self::assertNotEquals($oldClient, App::get(HttpClientInterface::class));
    }
}