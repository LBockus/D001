<?php

use App\Controllers\AdminController;
use App\Controllers\ContactsController;
use App\Controllers\HomeController;
use App\Controllers\PortfolioController;
use App\Output;
use App\FS;
use App\Authenticator;
use App\Router;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . "/../vendor/larapack/dd/src/helper.php";

$log = new Logger('Profile');
$log->pushHandler(new StreamHandler('../logs/errors.log', Logger::WARNING));

$output = new Output();

try {
    session_start();

    $router = new Router();
    $router->addRoute('GET', '', [new HomeController(), 'index']);
    $router->addRoute('GET', 'admin', [new AdminController(), 'index']);
    $router->addRoute('GET', 'contact', [new ContactsController(), 'index']);
    $router->addRoute('GET', 'portfolio', [new PortfolioController(), 'index']);
    $router->run();

} catch (Exception $e) {
    $output->store('An error occurred, try again later.');
    $log->error($e->getMessage());
}
$output->print();