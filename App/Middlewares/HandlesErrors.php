<?php

namespace App\Middlewares;

use App\Exceptions\ErrorHandler;
use App\Router\Middleware;
use App\Router\Response;
use Closure;

class HandlesErrors implements Middleware
{
	/**
	 * @var ErrorHandler
	 */
	private $errorHandler;

	public function __construct(ErrorHandler $errorHandler)
	{
		$this->errorHandler = $errorHandler;
	}

	public function handle(Closure $next, array $params): Response
	{
		try {
			return $next($params);
		} catch (\Exception $exception) {
			return $this->errorHandler->handle($exception);
		}
	}
}