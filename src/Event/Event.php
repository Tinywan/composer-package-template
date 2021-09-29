<?php

declare(strict_types=1);

namespace Tinywan\Template\Event;

use Tinywan\Template\Rocket;

class Event
{
    /**
     * @var \Tinywan\Template\Rocket|null
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
