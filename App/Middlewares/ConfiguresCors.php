<?php

namespace App\Middlewares;

use App\Router\Middleware;
use App\Router\Response;
use Closure;

class ConfiguresCors implements Middleware
{
	public function handle(Closure $next, array $params): Response
	{
		/** @var Response $response */
		$response = $next($params);

		$response->withHeader('Access-Control-Allow-Origin', '*');

		return $response;
	}
}