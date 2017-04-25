<?php

use Pumpkin\Command\GetCurrentWeatherStatus;
use Pumpkin\Repository\Weather\GuessWeather;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Application();
$app->add(new GetCurrentWeatherStatus('Weather:GetCurrentStatus', new GuessWeather()));
$app->run();