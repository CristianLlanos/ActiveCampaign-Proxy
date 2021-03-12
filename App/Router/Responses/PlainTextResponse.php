<?php

namespace App\Router\Responses;

use App\Router\Headers;
use App\Router\Response;

class PlainTextResponse implements Response
{
	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var int
	 */
	private $statusCode;

	/**
	 * @var Headers
	 */
	private $headers;

	/**
	 * PlainTextResponse constructor.
	 * @param string $content
	 * @param int $statusCode
	 */
	public function __construct(string $content = '', int $statusCode = 200)
	{
		$this->content = $content;
		$this->statusCode = $statusCode;
		$this->headers = new Headers();
		$this->withHeader('Content-type', 'text/plain; charset=UTF-8');
	}

	public function getContent(): string
	{
		return $this->content;
	}

	public function withStatusCode(int $code): Response
	{
		$this->statusCode = $code;

		return $this;
	}

	public function getStatusCode(): int
	{
		return $this->statusCode;
	}

	public function withHeader(string $name, string $value): Response
	{
		$this->getHeaders()->put($name, $value);

		return $this;
	}

	public function getHeaders(): Headers
	{
		return $this->headers;
	}
}