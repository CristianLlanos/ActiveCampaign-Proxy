<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class HttpException extends Exception
{
	/**
	 * @var int
	 */
	private $statusCode;

	/**
	 * NotFoundException constructor.
	 *
	 * @param int $statusCode
	 * @param string $message
	 * @param int $code
	 * @param Throwable|null $previous
	 */
	public function __construct(int $statusCode = 500, $message = "", $code = 0, Throwable $previous = null)
	{
		parent::__construct($message ?: 'Http Exception', $code, $previous);
		$this->statusCode = $statusCode;
	}

	public function getStatusCode() : int
	{
		return $this->statusCode;
	}
}