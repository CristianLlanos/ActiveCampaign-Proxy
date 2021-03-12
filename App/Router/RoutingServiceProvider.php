<?php

namespace App\Router;

use App\Router\Router;
use App\Routes;

class RoutingServiceProvider
{
	public function boot(Router $router, Routes $routes)
	{
		$routes->register($router);
		$routes->middleware($router);
	}
}