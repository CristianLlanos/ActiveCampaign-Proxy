<?php

namespace App\Router;

use App\Exceptions\NotFoundHttpException;
use Closure;
use Reliese\Component\Dependency\DependencyLocator;

class Router
{
	/**
	 * @var string[]
	 */
	private $routes = [];

	/**
	 * @var string[]
	 */
	private $middlewares = [];

	/**
	 * @var DependencyLocator
	 */
	private $container;

	public function __construct(DependencyLocator $container)
	{
		$this->container = $container;
	}

	public function add(string $route, string $action): Router
	{
		$this->routes[$route] = $action;

		return $this;
	}

	private function has(string $method): bool
	{
		return array_key_exists($method, $this->routes);
	}

	public function pipe(string $middleware): Router
	{
		$this->middlewares[] = $middleware;

		return $this;
	}

	public function serve(string $method, array $params) : Response
	{
		return $this->process($this->resolveAction($method))($params);
	}

	private function resolveAction(string $method): Closure
	{
		return function ($params) use ($method) {
			if (!$this->has($method)) {
				throw new NotFoundHttpException();
			}

			$route = $this->routes[$method];

			$action = $this->container->resolve($route);

			return $action->handle($params);
		};
	}

	private function process(Closure $passed): Closure
	{
		$middlewares = array_reverse($this->middlewares);

		foreach ($middlewares as $middleware) {
			$passed = function ($params) use ($middleware, $passed) {
				return $this->container->resolve($middleware)->handle($passed, $params);
			};
		}

		return $passed;
	}
}