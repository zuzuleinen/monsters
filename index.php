<?php

ini_set('display_errors', 'On');

require 'vendor/autoload.php';

$applicationConfiguration = new \Andrei\App\Config();
$frontController = new Andrei\App\FrontController($applicationConfiguration);

try {
    $frontController->dispatch();
} catch (\Exception $ex) {
    echo $ex->getMessage();
}