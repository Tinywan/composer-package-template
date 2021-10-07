<?php
/**
 * @desc Logger.php 描述信息
 * @date 2021/9/29 15:33
 */

namespace Tinywan\Template;

use Tinywan\Template\Contract\ConfigInterface;
use Tinywan\Template\Contract\LoggerInterface;
use Tinywan\Template\Exception\InvalidConfigException;

/**
 * Class Logger.
 *
 * @method static void emergency($message, array $context = [])
 * @method static void alert($message, array $context = [])
 * @method static void critical($message, array $context = [])
 * @method static void error($message, array $context = [])
 * @method static void warning($message, array $context = [])
 * @method static void notice($message, array $context = [])
 * @method static void info($message, array $context = [])
 * @method static void debug($message, array $context = [])
 * @method static void log($message, array $context = [])
 */
class Logger
{
    /**
     * @param string $method
     * @param array $args
     * @throws Exception\ContainerDependencyException
     * @throws Exception\ContainerException
     * @throws Exception\ContainerNotFoundException
     * @throws Exception\ServiceNotFoundException
     * @throws InvalidConfigException
     */
    public static function __callStatic(string $method, array $args): void
    {
        if (!App::hasContainer() || !App::has(LoggerInterface::class) ||
            false === App::get(ConfigInterface::class)->get('logger.enable', false)) {
            return;
        }

        $class = App::get(LoggerInterface::class);

        if ($class instanceof \Psr\Log\LoggerInterface || $class instanceof \Yansongda\Supports\Logger) {
            $class->{$method}(...$args);

            return;
        }

        throw new InvalidConfigException(Exception\Exception::LOGGER_CONFIG_ERROR);
    }
}
