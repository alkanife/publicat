<?php
namespace Publicat;

use Bramus\Router\Router;
use Publicat\Util\Loader;
use Throwable;

// DEVELOPER CONSTANTS, ONLY SET PUBLICAT_DEV TO TRUE FOR DEBUG PURPOSES, AND ON A LOCAL SERVER.
define('PUBLICAT_MAINTENANCE', false);
define('PUBLICAT_DEV', true);
// -------------------------------

// Require the loader, exit if an error is caught
try {
    @require_once 'util/Loader.php';
} catch (Throwable $t) {
    http_response_code(500);
    if (PUBLICAT_DEV)
        die('500: The file "util/Loader.php" was not found or caused a critical error.');
    else
        die('Internal Server Error');
}

// Create & call the loader
$loader = new Loader();
$loader->load();

// Get error handler created by loader
$errorHandler = $loader->getErrorHandler();

// Create & call the router
$router = new Router($errorHandler);
$router->createPublicatRoutes();

// Create a default try catch,
// Every error, if there is no other try/catch block will be caught here.
try {
    ini_set('session.name', 'publicat_session');
    session_start();
    $router->run();
} catch (Throwable $throwable) {
    $errorHandler->catchError($throwable);
    $errorHandler->displayViewAndDie(500);
}