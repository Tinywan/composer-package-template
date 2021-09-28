<?php

declare(strict_types=1);

namespace Tinywan\Template\Event;

class MethodCalled extends Event
{
    /**
     * @var string
     */
    public $provider;

    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $params;

    public function __construct(string $provider, string $name, array $params, ?Rocket $rocket)
    {
        $this->provider = $provider;
        $this->name = $name;
        $this->params = $params;

        parent::__construct($rocket);
    }
}