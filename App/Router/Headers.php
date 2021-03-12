<?php

namespace App\Router;

class Headers
{
	private $list = [];

	public function all(): array
	{
		return $this->list;
	}

	public function put(string $name, string $value): Headers
	{
		$this->list[$name] = $value;

		return $this;
	}

	public function remove(string $name): Headers
	{
		unset($this->list[$name]);

		return $this;
	}
}