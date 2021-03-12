<?php

namespace App\Exceptions;

use App\Router\Response;
use App\Router\Responses\PlainTextResponse;

class ErrorHandler
{
	public function handle(\Exception $exception): Response
	{
		// Send logs

		$statusCode = 500;

		if ($exception instanceof HttpException) {
			$statusCode = $exception->getStatusCode();
		}

		$response = new PlainTextResponse();

		$response->withStatusCode($statusCode);

		return $response;
	}
}