<?php

use App\Controllers\AdminController;
use App\Controllers\ContactsController;
use App\Controllers\HomeController;
use App\Controllers\PortfolioController;
use App\ExceptionHandler;
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

    $authenticator = new Authenticator();
    $adminController = new AdminController($authenticator);

    $router = new Router();
    $router->addRoute('GET', '', [new HomeController(), 'index']);
    $router->addRoute('GET', 'admin', [$adminController, 'index']);
    $router->addRoute('POST', 'login', [$adminController, 'login']);
    $router->addRoute('GET', 'contacts', [new ContactsController($log), 'index']);
    $router->addRoute('GET', 'portfolio', [new PortfolioController(), 'index']);
    $router->addRoute('POST', 'portfolio', [new PortfolioController(), 'store']);
    $router->addRoute('GET', 'logout', [$adminController, 'logout']);
    $router->run();
}
catch (Exception $e) {
    $handler = new ExceptionHandler($output, $log);
    $handler->handle($e);
}

// Spausdinam viska kas buvo 'Storinta' Output klaseje
$output->print();