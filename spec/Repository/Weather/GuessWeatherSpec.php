<?php

namespace spec\Pumpkin\Repository\Weather;

use Pumpkin\Location\LocationInterface;
use Pumpkin\Repository\Weather\GuessWeather;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Pumpkin\Repository\Weather\WeatherRepositoryInterface;
use Pumpkin\Weather\CurrentStatus;

class GuessWeatherSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'beAValidWeatherType' => function ($subject) {
                return in_array($subject->status(), ['rain', 'sun', 'snow']);
            },
        ];
    }

    function it_implements_weather_repository_interface()
    {
        $this->shouldImplement(WeatherRepositoryInterface::class);
    }

    function it_returns_an_instance_of_current_status(LocationInterface $location)
    {
        $this->getCurrentStatus($location)->shouldHaveType(CurrentStatus::class);
    }

    function it_returns_a_valid_status(LocationInterface $location)
    {
        $this->getCurrentStatus($location)->shouldBeAValidWeatherType();
    }

}
