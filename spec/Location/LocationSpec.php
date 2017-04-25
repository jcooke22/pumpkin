<?php

namespace spec\Pumpkin\Location;

use InvalidArgumentException;
use Pumpkin\Location\Location;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Pumpkin\Location\LocationInterface;

class LocationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('UK', "London");
    }

    function it_implements_location_interface()
    {
        $this->shouldHaveType(LocationInterface::class);
    }

    function it_exposes_country()
    {
        $this->country()->shouldReturn('UK');
    }

    function it_converts_lower_case_country_to_upper_case()
    {
        $this->beConstructedWith('uk', "London");
        $this->country()->shouldReturn('UK');
    }

    function it_throws_an_exception_if_the_country_is_empty()
    {
        $this->beConstructedWith('', "London");
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_if_the_country_is_whitespace()
    {
        $this->beConstructedWith('   ', "London");
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_if_the_country_is_numeric()
    {
        $this->beConstructedWith('12', "London");
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_if_the_country_is_alpha_numeric()
    {
        $this->beConstructedWith('A2', "London");
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_if_the_country_is_too_short()
    {
        $this->beConstructedWith('A', "London");
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_if_the_country_is_too_long()
    {
        $this->beConstructedWith('AAA', "London");
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_exposes_city()
    {
        $this->city()->shouldReturn("London");
    }

    function it_throws_an_exception_if_the_city_is_empty()
    {
        $this->beConstructedWith('UK', "");
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_if_the_city_is_whitespace()
    {
        $this->beConstructedWith('UK', "     ");
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

}