<?php

namespace Tinywan\Template\Parser;

use Psr\Http\Message\ResponseInterface;
use Tinywan\Template\App;
use Tinywan\Template\Contract\ParserInterface;
use Yansongda\Supports\Collection;

class CollectionParser implements ParserInterface
{
    public function parse(?ResponseInterface $response): Collection
    {
        return new Collection(
            App::get(ArrayParser::class)->parse($response)
        );
    }
}
