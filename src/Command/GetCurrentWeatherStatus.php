<?php

namespace Pumpkin\Command;

use InvalidArgumentException as BaseInvalidArgumentException;
use Pumpkin\Weather\WeatherRepositoryException;
use Symfony\Component\Console\Exception\InvalidArgumentException as ConsoleInvalidArgumentException;
use Pumpkin\Location\Location;
use Pumpkin\Repository\Weather\WeatherRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCurrentWeatherStatus extends Command
{
    /**
     * @var WeatherRepositoryInterface
     */
    private $weatherRepository;

    /**
     * GetCurrentWeatherStatus constructor.
     * @param string $name
     * @param WeatherRepositoryInterface $weatherRepository
     */
    public function __construct(string $name, WeatherRepositoryInterface $weatherRepository)
    {
        $this->weatherRepository = $weatherRepository;
        parent::__construct($name);
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('Weather:GetCurrentStatus');
        $this->setDescription('Get the current weather for a given location');
        $this->setHelp('Provide the 2 letter country code (ISO 3166) and the city');
        $this->addArgument('country', InputArgument::REQUIRED);
        $this->addArgument('city', InputArgument::REQUIRED);
    }

    /**
     * @inheritdoc
     */
    public function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        try {
            $location = new Location($input->getArgument('country'), $input->getArgument('city'));
        } catch (BaseInvalidArgumentException $e) {
            throw new ConsoleInvalidArgumentException($e->getMessage());
        }

        try {
            $currentStatus = $this->weatherRepository->getCurrentStatus($location);
        } catch (WeatherRepositoryException $e) {
            throw new RuntimeException($e->getMessage());
        }
        
        $output->write((string) $currentStatus);
        
        return $output;
    }
}
