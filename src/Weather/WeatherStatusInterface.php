<?php

namespace Pumpkin\Weather;

use Pumpkin\Location\LocationInterface;

interface WeatherStatusInterface
{
    /**
     * @return LocationInterface
     */
    public function location(): LocationInterface;

    /**
     * @return string
     */
    public function status(): string;

    /**
     * @return string
     */
    public function __toString(): string;
}