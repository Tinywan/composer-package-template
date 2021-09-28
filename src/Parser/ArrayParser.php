<?php

declare(strict_types=1);

namespace Tinywan\Template\Parser;

use Psr\Http\Message\ResponseInterface;
use Tinywan\Template\Contract\ParserInterface;
use Tinywan\Template\Exception\Exception;
use Tinywan\Template\Exception\InvalidResponseException;

class ArrayParser implements ParserInterface
{
    public function parse(?ResponseInterface $response): array
    {
        if (is_null($response)) {
            throw new InvalidResponseException(Exception::RESPONSE_NONE);
        }

        $contents = $response->getBody()->getContents();

        $result = json_decode($contents, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidResponseException(Exception::UNPACK_RESPONSE_ERROR, 'Unpack Response Error', ['contents' => $contents, 'response' => $response]);
        }

        return $result;
    }
}