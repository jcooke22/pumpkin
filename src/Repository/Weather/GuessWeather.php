<?php

namespace Pumpkin\Repository\Weather;

use Pumpkin\Location\LocationInterface;
use Pumpkin\Weather\CurrentStatus;

class GuessWeather implements WeatherRepositoryInterface
{
    /**
     * @var array
     */
    const AVAILABLE_WEATHER = ['rain', 'sun', 'snow'];

    /**
     * @param LocationInterface $location
     *
     * @return CurrentStatus
     */
    public function getCurrentStatus(LocationInterface $location): CurrentStatus
    {
        return new CurrentStatus(
            $location,
            static::AVAILABLE_WEATHER[array_rand(static::AVAILABLE_WEATHER)]
        );
    }
}
