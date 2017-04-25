<?php

namespace spec\Pumpkin\Weather;

use InvalidArgumentException;
use Pumpkin\Location\LocationInterface;
use Pumpkin\Weather\CurrentStatus;
use PhpSpec\ObjectBehavior;
use Pumpkin\Weather\WeatherStatusInterface;

class CurrentStatusSpec extends ObjectBehavior
{
    function let(LocationInterface $location)
    {
        // Arrange
        $this->beConstructedWith($location, "Sunny");
    }

    function it_implements_the_weather_status_interface()
    {
        // Assert
        $this->shouldHaveType(WeatherStatusInterface::class);
    }

    function it_exposes_location($location)
    {
        // Act / Assert
        $this->location()->shouldReturn($location);
    }

    function it_exposes_status()
    {
        // Act / Assert
        $this->status()->shouldReturn("Sunny");
    }

    function it_throws_an_exception_if_the_status_is_empty($location)
    {
        // Arrange
        $this->beConstructedWith($location, "");

        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_if_the_status_is_whitespace($location)
    {
        // Arrange
        $this->beConstructedWith($location, "   ");

        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_returns_a_string_representation_of_the_location_and_weather(LocationInterface $location)
    {
        // Arrange
        $location->country()->willReturn('UK');
        $location->city()->willReturn('London');
        $this->beConstructedWith($location, "rain");
        
        // Act / Assert
        $this->__toString()->shouldReturn("The current weather in London, UK is rain.");
    }

}
