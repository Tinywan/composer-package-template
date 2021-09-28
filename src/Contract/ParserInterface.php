<?php

declare(strict_types=1);

namespace Tinywan\Template\Contract;

use Psr\Http\Message\ResponseInterface;

interface ParserInterface
{
    /**
     * @return mixed
     */
    public function parse(?ResponseInterface $response);
}