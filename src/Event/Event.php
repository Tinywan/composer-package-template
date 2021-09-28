<?php

declare(strict_types=1);

namespace Tinywan\Template\Event;

class Event
{
    /**
     * @var \Yansongda\Pay\Rocket|null
     */
    public $rocket;

    /**
     * Bootstrap.
     */
    public function __construct(?Rocket $rocket)
    {
        $this->rocket = $rocket;
    }
}