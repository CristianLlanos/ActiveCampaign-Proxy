<?php

namespace App\Router;

interface Response
{
	public function getContent() : string;

	public function withStatusCode(int $code) : Response;

	public function getStatusCode() : int;

	public function withHeader(string $name, string $value) : Response;

	public function getHeaders() : Headers;
}