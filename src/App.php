<?php

declare(strict_types=1);

namespace Tinywan\Template;

use DI\Container;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Tinywan\Template\Contract\ServiceProviderInterface;
use Tinywan\Template\Exception\ContainerDependencyException;
use Tinywan\Template\Exception\ContainerException;
use Tinywan\Template\Exception\ContainerNotFoundException;
use Tinywan\Template\Exception\ServiceNotFoundException;
use Tinywan\Template\Service\AlipayServiceProvider;
use Tinywan\Template\Service\ConfigServiceProvider;
use Tinywan\Template\Service\HttpServiceProvider;
use Tinywan\Template\Service\LoggerServiceProvider;

class App
{
    /**
     * 正常模式.
     */
    public const MODE_NORMAL = 0;

    /**
     * 沙箱模式.
     */
    public const MODE_SANDBOX = 1;

    /**
     * 服务商模式.
     */
    public const MODE_SERVICE = 2;

    /**
     * @var string[]
     */
    protected $service = [
        AlipayServiceProvider::class,
    ];

    /**
     * kernel  Service.
     *
     * @var string[]
     */
    private $kernelService = [
        ConfigServiceProvider::class,
        LoggerServiceProvider::class,
        HttpServiceProvider::class,
    ];

    /**
     * @var \DI\Container|null
     */
    private static $container = null;

    private function __construct(array $config)
    {
        $this->initContainer();
        $this->registerKernelService($config);
    }

    /**
     * __callStatic.
     *
     * @return mixed
     */
    public static function __callStatic(string $service, array $config)
    {
        if (!empty($config)) {
            self::config(...$config);
        }

        return self::get($service);
    }

    /**
     * 初始化容器、配置等信息.
     */
    public static function config(array $config = []): App
    {
        if (self::hasContainer() && !($config['_force'] ?? false)) {
            return self::get(App::class);
        }

        return new self($config);
    }

    /**
     * 获取容器实例.
     *
     * @return mixed
     */
    public static function get(string $service)
    {
        try {
            return App::getContainer()->get($service);
        } catch (NotFoundException $e) {
            throw new ServiceNotFoundException($e->getMessage());
        } catch (DependencyException $e) {
            throw new ContainerDependencyException($e->getMessage());
        } catch (\Throwable $e) {
            throw new ContainerException($e->getMessage());
        }
    }

    /**
     * 定义.
     *
     * @param mixed $value
     *
     * @throws ContainerException
     */
    public static function set(string $name, $value): void
    {
        App::getContainer()->set($name, $value);
    }

    /**
     * 判断容器中是否存在类及标识.
     */
    public static function has(string $service): bool
    {
        return App::getContainer()->has($service);
    }

    /**
     * getContainer.
     *
     * @throws ContainerNotFoundException
     */
    public static function getContainer(): Container
    {
        if (self::hasContainer()) {
            return self::$container;
        }

        throw new ContainerNotFoundException('You should init/config App first', Exception\Exception::CONTAINER_NOT_FOUND);
    }

    /**
     * has Container.
     */
    public static function hasContainer(): bool
    {
        return isset(self::$container) && self::$container instanceof Container;
    }

    /**
     * 创建类的容器实例.
     *
     * @return mixed
     *
     * @throws ContainerDependencyException
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    public static function make(string $service, array $parameters = [])
    {
        try {
            return App::getContainer()->make(...func_get_args());
        } catch (NotFoundException $e) {
            throw new ServiceNotFoundException($e->getMessage());
        } catch (DependencyException $e) {
            throw new ContainerDependencyException($e->getMessage());
        } catch (\Throwable $e) {
            throw new ContainerException($e->getMessage());
        }
    }

    /**
     * clear.
     */
    public static function clear(): void
    {
        self::$container = null;
    }

    /**
     * 注册服务
     *
     * @throws ContainerDependencyException
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    public static function registerService(string $service, array $config): void
    {
        $var = self::get($service);

        if ($var instanceof ServiceProviderInterface) {
            $var->register(self::get(App::class), $config);
        }
    }

    /**
     * initContainer.
     *
     * @throws ContainerException
     */
    private function initContainer(): void
    {
        $builder = new ContainerBuilder();
        $builder->useAnnotations(false);

        try {
            $container = $builder->build();
            $container->set(ContainerException ::class, $container);
            $container->set(\Psr\Container\ContainerInterface::class, $container);
            $container->set(App::class, $this);
            self::$container = $container;
        } catch (\Throwable $e) {
            throw new ContainerException($e->getMessage());
        }
    }

    /**
     * register Kernel service.
     *
     * @throws ContainerDependencyException
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    private function registerKernelService(array $config): void
    {
        foreach (array_merge($this->kernelService, $this->service) as $service) {
            self::registerService($service, $config);
        }
    }
}
