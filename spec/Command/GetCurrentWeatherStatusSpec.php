<?php

namespace spec\Pumpkin\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Pumpkin\Repository\Weather\WeatherRepositoryInterface;
use Pumpkin\Weather\CurrentStatus;
use Pumpkin\Weather\WeatherRepositoryException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCurrentWeatherStatusSpec extends ObjectBehavior
{
    function let(
        WeatherRepositoryInterface $weatherRepository
    ) {
        // Arrange
        $this->beConstructedWith('Weather:GetCurrentStatus', $weatherRepository);
    }

    function it_extends_command()
    {
        // Assert
        $this->shouldHaveType(Command::class);
    }

    function it_exposes_the_command_name()
    {
        // Act / Assert
        $this->getName()->shouldReturn('Weather:GetCurrentStatus');
    }

    function it_exposes_the_command_description()
    {
        // Act / Assert
        $this->getDescription()->shouldReturn('Get the current weather for a given location');
    }

    function it_exposes_the_command_help()
    {
        // Act / Assert
        $this->getHelp()->shouldReturn('Provide the 2 letter country code (ISO 3166) and the city');
    }

    function it_has_a_required_argument_of_country()
    {
        $this->getDefinition()->getArgument('country')->shouldHaveType(InputArgument::class);
    }
    
    function it_has_a_required_argument_of_city()
    {
        $this->getDefinition()->getArgument('city')->shouldHaveType(InputArgument::class);
    }

    function it_returns_an_output_object_from_an_input_object(
        InputInterface $input,
        OutputInterface $output,
        $weatherRepository,
        CurrentStatus $currentStatus
    ) {
        // Arrange
        $input->getArgument('country')->willReturn('UK');
        $input->getArgument('city')->willReturn('London');
        $currentStatus->__toString()->willReturn("The current weather in London, UK is rain.");
        $weatherRepository->getCurrentStatus(Argument::any())->willReturn($currentStatus);

        // Act / Assert
        $this->execute($input, $output)->shouldImplement(OutputInterface::class);
    }

    function it_throws_an_exception_if_the_input_country_is_not_set(InputInterface $input, OutputInterface $output)
    {
        // Arrange
        $input->getArgument('country')->willThrow(InvalidArgumentException::class);

        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('execute', [$input, $output]);
    }

    function it_throws_an_exception_if_the_county_is_not_valid(InputInterface $input, OutputInterface $output)
    {
        // Arrange
        $input->getArgument('country')->willReturn("foo");
        $input->getArgument('city')->willReturn("London");

        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('execute', [$input, $output]);
    }

    function it_throws_an_exception_if_the_input_city_is_not_set(InputInterface $input, OutputInterface $output)
    {
        // Arrange
        $input->getArgument('country')->willReturn('UK');
        $input->getArgument('city')->willThrow(InvalidArgumentException::class);

        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('execute', [$input, $output]);
    }

    function it_throws_an_exception_if_the_city_is_not_valid(InputInterface $input, OutputInterface $output)
    {
        // Arrange
        $input->getArgument('country')->willReturn("UK");
        $input->getArgument('city')->willReturn("        ");

        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('execute', [$input, $output]);
    }

    function it_throws_an_exception_when_the_weather_repository_throws_an_exception(
        WeatherRepositoryInterface $weatherRepository,
        InputInterface $input,
        OutputInterface $output
    ) {
        // Arrange
        $input->getArgument('country')->willReturn("UK");
        $input->getArgument('city')->willReturn("London");
        $weatherRepository->getCurrentStatus(Argument::any())->willThrow(WeatherRepositoryException::class);

        // Act / Assert
        $this->shouldThrow(RuntimeException::class)->during('execute', [$input, $output]);
    }

    function it_writes_the_correct_string_to_output(
        WeatherRepositoryInterface $weatherRepository,
        InputInterface $input,
        OutputInterface $output,
        CurrentStatus $weatherStatus
    ) {
        // Arrange
        $input->getArgument('country')->willReturn("UK");
        $input->getArgument('city')->willReturn("London");
        $weatherStatus->__toString()->willReturn("The current weather in London, UK is rain.");
        $weatherRepository->getCurrentStatus(Argument::any())->willReturn($weatherStatus);

        // Act
        $this->execute($input, $output);

        // Assert
        $output->write("The current weather in London, UK is rain.")->shouldHaveBeenCalled();
    }
}
