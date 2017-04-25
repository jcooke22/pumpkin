<?php

namespace Pumpkin\Repository\Weather;

use Pumpkin\Location\LocationInterface;
use Pumpkin\Weather\CurrentStatus;

/**
 * Interface WeatherRepositoryInterface
 */
interface WeatherRepositoryInterface
{
    /**
     * @param LocationInterface $location
     * 
     * @return CurrentStatus
     */
    public function getCurrentStatus(LocationInterface $location): CurrentStatus;
}