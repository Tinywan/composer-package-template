<?php
/**
 * @desc NoHttpRequestParser.php 描述信息
 * @date 2021/9/29 16:33
 */

declare(strict_types=1);

namespace Tinywan\Template\Parser;

use Psr\Http\Message\ResponseInterface;
use Tinywan\Template\Contract\ParserInterface;

class NoHttpRequestParser implements ParserInterface
{
    public function parse(?ResponseInterface $response): ?ResponseInterface
    {
        return $response;
    }
}
