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
    protected array $service = [
        AlipayServiceProvider::class,
    ];

    /**
     * kernel  Service.
     *
     * @var string[]
     */
    private array $kernelService = [
        ConfigServiceProvider::class,
        LoggerServiceProvider::class,
        HttpServiceProvider::class,
    ];

    /**
     * @var Container|null
     */
    private static ?Container $container = null;

    /**
     * @param array $config
     */
    private function __construct(array $config)
    {
        try {
            $this->initContainer();
        } catch (ContainerException $e) {
        }
        try {
            $this->registerKernelService($config);
        } catch (ContainerDependencyException $e) {
        } catch (ContainerException $e) {
        } catch (ServiceNotFoundException $e) {
        }
    }

    /**
     * __callStatic.
     *
     * @param string $service
     * @param array $config
     * @return mixed
     * @throws ContainerDependencyException
     * @throws ContainerException
     * @throws ServiceNotFoundException
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
     * @param array $config
     * @return App
     * @throws ContainerDependencyException
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    public static function config(array $config = []): App
    {
        if (self::hasContainer() && !($config['_force'] ?? false)) {
            return self::get(App::class);
        }

        return new self($config);
    }

    /**
     * get container instance
     *
     * @param string $service
     * @return mixed
     * @throws ContainerDependencyException
     * @throws ContainerException
     * @throws ServiceNotFoundException
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
     * set container instance.
     *
     * @param string $name
     * @param mixed $value
     *
     * @throws ContainerNotFoundException
     */
    public static function set(string $name, $value): void
    {
        App::getContainer()->set($name, $value);
    }

    /**
     * 判断容器中是否存在类及标识.
     * @param string $service
     * @return bool
     * @throws ContainerNotFoundException
     */
    public static function has(string $service): bool
    {
        return App::getContainer()->has($service);
    }

    /**
     * getContainer.
     * @return Container
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
     * @return bool
     */
    public static function hasContainer(): bool
    {
        return isset(self::$container) && self::$container instanceof Container;
    }

    /**
     * 创建类的容器实例.
     *
     * @param string $service
     * @param array $parameters
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
     * @param string $service
     * @param array $config
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
     * init container.
     *
     * @throws ContainerException
     */
    private function initContainer(): void
    {
        try {
            $builder = new ContainerBuilder();
            $builder->useAnnotations(false);
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
     * @param array $config
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
