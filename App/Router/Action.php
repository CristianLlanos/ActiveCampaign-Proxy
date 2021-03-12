<?php

namespace App\Router;

interface Action
{
	public function handle(array $params): Response;
}