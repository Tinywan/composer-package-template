<?php

declare(strict_types=1);

namespace Tinywan\Template;

use ArrayAccess;
use JsonSerializable as JsonSerializableInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Serializable as SerializableInterface;
use Yansongda\Supports\Collection;
use Yansongda\Supports\Traits\Accessable;
use Yansongda\Supports\Traits\Arrayable;
use Yansongda\Supports\Traits\Serializable;

class Rocket implements JsonSerializableInterface, SerializableInterface, ArrayAccess
{
    use Accessable;
    use Arrayable;
    use Serializable;

    /**
     * @var RequestInterface|null
     */
    private ?RequestInterface $radar = null;

    /**
     * @var array
     */
    private array $params = [];

    /**
     * @var Collection|null
     */
    private ?Collection $payload = null;

    /**
     * @var string|null
     */
    private ?string $direction = null;

    /**
     * @var Collection|MessageInterface|array|null
     */
    private $destination = null;

    /**
     * @var MessageInterface|null
     */
    private ?MessageInterface $destinationOrigin = null;

    /**
     * @return RequestInterface|null
     */
    public function getRadar(): ?RequestInterface
    {
        return $this->radar;
    }

    /**
     * @param RequestInterface|null $radar
     * @return $this
     */
    public function setRadar(?RequestInterface $radar): Rocket
    {
        $this->radar = $radar;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params): Rocket
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function mergeParams(array $params): Rocket
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getPayload(): ?Collection
    {
        return $this->payload;
    }

    /**
     * @param Collection|null $payload
     * @return $this
     */
    public function setPayload(?Collection $payload): Rocket
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @param array $payload
     * @return $this
     */
    public function mergePayload(array $payload): Rocket
    {
        if (empty($this->payload)) {
            $this->payload = new Collection();
        }

        $this->payload = $this->payload->merge($payload);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDirection(): ?string
    {
        return $this->direction;
    }

    /**
     * @param string|null $direction
     * @return $this
     */
    public function setDirection(?string $direction): Rocket
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return MessageInterface|Collection|array|null
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param MessageInterface|Collection|array|null $destination
     */
    public function setDestination($destination): Rocket
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDestinationOrigin(): ?MessageInterface
    {
        return $this->destinationOrigin;
    }

    /**
     * @param MessageInterface|null $destinationOrigin
     * @return $this
     */
    public function setDestinationOrigin(?MessageInterface $destinationOrigin): Rocket
    {
        $this->destinationOrigin = $destinationOrigin;

        return $this;
    }
}
