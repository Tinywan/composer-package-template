<?php
/**
 * @desc Request.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 11:37
 */

declare(strict_types=1);

namespace Tinywan\Template;


use JsonSerializable as JsonSerializableInterface;
use Serializable  as SerializableInterface;
use Yansongda\Supports\Traits\Accessable;
use Yansongda\Supports\Traits\Arrayable;
use Yansongda\Supports\Traits\Serializable;

class Request extends \GuzzleHttp\Psr7\Request implements JsonSerializableInterface,SerializableInterface
{
    use Accessable;
    use Arrayable;
    use Serializable;

    public function toArray(): array
    {
        return [
            'url' => $this->getUri()->__toString(),
            'method' => $this->getMethod(),
            'headers' => $this->getHeaders(),
            'body' => $this->getBody()->getContents(),
        ];
    }
}