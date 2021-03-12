<?php

namespace App\Middlewares;

use App\Router\Middleware;
use App\Router\Response;
use App\Router\Responses\PlainTextResponse;
use Closure;

class RespondsOptionsRequests implements Middleware
{
	public function handle(Closure $next, array $params): Response
	{
		if ($this->isOptionsRequest()) {
			return $this->skipResponse();
		}

		return $next($params);
	}

	/**
	 * @return bool
	 */
	private function isOptionsRequest(): bool
	{
		return $_SERVER['REQUEST_METHOD'] == 'OPTIONS';
	}

	/**
	 * @return Response
	 */
	private function skipResponse(): Response
	{
		$response = new PlainTextResponse();

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
			$response->withHeader(
				'Access-Control-Allow-Methods',
				'GET, OPTIONS'
			);
		}

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
			$response->withHeader(
				'Access-Control-Allow-Headers',
				$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']
			);
		}

		return $response;
	}
}