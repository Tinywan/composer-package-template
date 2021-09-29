<?php
/**
 * @desc ParserPlugin.php 描述信息
 * @date 2021/9/29 15:29
 */
declare(strict_types=1);

namespace Tinywan\Template\Plugin;

use Tinywan\Template\App;
use Tinywan\Template\Contract\ParserInterface;
use Tinywan\Template\Contract\PluginInterface;
use Tinywan\Template\Exception\Exception;
use Tinywan\Template\Exception\InvalidConfigException;
use Tinywan\Template\Rocket;

class ParserPlugin implements PluginInterface
{
    public function assembly(Rocket $rocket, \Closure $next): Rocket
    {
        /* @var Rocket $rocket */
        $rocket = $next($rocket);

        /* @var \Psr\Http\Message\ResponseInterface $response */
        $response = $rocket->getDestination();

        return $rocket->setDestination(
            $this->getPacker($rocket)->parse($response)
        );
    }

    protected function getPacker(Rocket $rocket): ParserInterface
    {
        $packer = App::get($rocket->getDirection() ?? ParserInterface::class);

        $packer = is_string($packer) ? App::get($packer) : $packer;

        if (!($packer instanceof ParserInterface)) {
            throw new InvalidConfigException(Exception::INVALID_PACKER);
        }

        return $packer;
    }
}
