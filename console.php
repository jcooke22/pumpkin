<?php

use Pumpkin\Command\GetCurrentWeatherStatus;
use Pumpkin\Repository\Weather\GuessWeatherRepository;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Application();
$app->add(new GetCurrentWeatherStatus('Weather:GetCurrentStatus', new GuessWeatherRepository()));
$app->run();