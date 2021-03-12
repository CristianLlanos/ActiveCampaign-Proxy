<?php

namespace App\Router;

use Closure;

interface Middleware
{
	public function handle(Closure $next, array $params): Response;
}