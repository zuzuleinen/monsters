<?php

ini_set('display_errors', 'On');

require 'vendor/autoload.php';

$request = \Andrei\App\Http\Request::init();
//normally application should act as a wrapper for frontcontroller
//if have more time i will refactor this
$application = new \Andrei\App\Application(new \Andrei\App\Config(), $request);
$frontController = new Andrei\App\FrontController($application);

try {
    $frontController->dispatch();
} catch (\Exception $ex) {
    echo $ex->getMessage();
}