<?php

use App\Redirect;
use Couchbase\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';
session_start();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:

        $handler = $routeInfo[1][0];
        $controller = $handler[0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];

        /** @var View $response */
        $response = (new $handler)->$method($vars);

        $loader = new FilesystemLoader('app/View');
        $twig = new Environment($loader);
        $twig->addGlobal('session', $_SESSION);

        if ($response instanceof View) {
            echo $twig->render($response->getPath(), $response->getVariables());
            break;
        }

        if ($response instanceof Redirect) {
            header('Location: ' . $response->getLocation());
            exit;
        }


        break;
}

if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}

if (isset($_SESSION['inputs'])) {
    unset($_SESSION['inputs']);
}
