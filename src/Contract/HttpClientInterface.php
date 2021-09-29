<?php

declare(strict_types=1);

namespace Tinywan\Template\Contract;

use GuzzleHttp\ClientInterface;

interface HttpClientInterface extends ClientInterface, \Psr\Http\Client\ClientInterface
{
}
