<?php

require_once '../vendor/autoload.php';

use App\Exceptions\ErrorHandler;
use App\Router\Router;
use App\Server;
use Reliese\Component\Dependency\Container;

$container = new Reliese\Dependency\Container();

$container->singleton('providers', function () {
	return [
		\App\Router\RoutingServiceProvider::class,
	];
});

$container->singleton(ErrorHandler::class, function () {
	return new ErrorHandler();
});

$container->singleton(Router::class, function (Container $container) {
	return new Router($container);
});

$container->singleton(Server::class, function (Container $container) {
	return new Server($container);
});

/** @var Server $server */
$server = $container->resolve(Server::class);

$server->run();