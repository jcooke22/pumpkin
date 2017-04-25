<?php

namespace Pumpkin\Weather;

use InvalidArgumentException;
use Pumpkin\Location\Location;
use Pumpkin\Location\LocationInterface;

class CurrentStatus implements WeatherStatusInterface
{
    /**
     * @var LocationInterface
     */
    private $location;
    /**
     * @var string
     */
    private $status;

    /**
     * CurrentStatus constructor.
     * @param LocationInterface $location
     * @param string $status
     */
    public function __construct(LocationInterface $location, string $status)
    {
        if (trim($status) == '') {
            throw new InvalidArgumentException('Empty status provided');
        }

        $this->location = $location;
        $this->status = $status;
    }

    /**
     * @return LocationInterface
     */
    public function location(): LocationInterface
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            "The current weather in %s, %s is %s.",
            $this->location()->city(),
            $this->location()->country(),
            $this->status()
        );
    }
}
