<?php
/**
 * @desc OriginResponseParser.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/11 10:41
 */

declare(strict_types=1);

namespace Tinywan\Template\Parser;


use Psr\Http\Message\ResponseInterface;
use Tinywan\Template\Contract\ParserInterface;
use Tinywan\Template\Exception\Exception;
use Tinywan\Template\Exception\InvalidResponseException;

class OriginResponseParser implements ParserInterface
{
    /**
     * @param ResponseInterface|null $response
     * @return ResponseInterface|null
     * @throws InvalidResponseException
     */
    public function parse(?ResponseInterface $response): ?ResponseInterface
    {
        if (!is_null($response)) {
            return $response;
        }

        throw new InvalidResponseException(Exception::INVALID_RESPONSE_CODE);
    }
}