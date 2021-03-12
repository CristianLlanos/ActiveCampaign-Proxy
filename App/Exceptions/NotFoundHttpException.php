<?php

namespace App\Exceptions;

use Throwable;

class NotFoundHttpException extends HttpException
{
	/**
	 * NotFoundException constructor.
	 *
	 * @param string $message
	 * @param int $code
	 * @param Throwable|null $previous
	 */
	public function __construct($message = "", $code = 0, Throwable $previous = null)
	{
		parent::__construct(404, $message ?: 'Not found', $code, $previous);
	}
}