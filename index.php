<?php
require 'vendor/autoload.php';
session_start();

use App\Controllers\ProductController;
use App\Redirect;
use App\Repositories\Products\PdoProductsRepository;
use App\Repositories\Products\ProductsRepository;
use App\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use function DI\create;

$builder = new DI\ContainerBuilder();
$builder->addDefinitions([
    ProductsRepository::class => create(PdoProductsRepository::class)
]);
$container = $builder->build();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/product/{id:\d+}', [ProductController::class, 'show']);
    $r->addRoute('GET', '/products', [ProductController::class, 'index']);

    $r->addRoute('GET', '/product/create', [ProductController::class, 'create']);
    $r->addRoute('POST', '/product/create', [ProductController::class, 'store']);

    $r->addRoute('POST', '/product/buy/{id:\d+}', [ProductController::class, 'buy']);
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

        $controller = $routeInfo[1][0];
        $method = $routeInfo[1][1];

        /** @var View $response */
        $response = ($container->get($controller))->$method($routeInfo[2]);

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
