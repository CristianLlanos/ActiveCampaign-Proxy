<?php

namespace App;

use App\Router\Response;
use App\Router\Router;
use Reliese\Component\Dependency\Container;

class Server
{
	/**
	 * @var Container
	 */
	private $container;

	/**
	 * Server constructor.
	 * @param Container $container
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;

		$this->boot();
	}

	private function boot()
	{
		$providers = $this->container->resolve('providers');

		foreach ($providers as $provider) {
			$registrar = $this->container->resolve($provider);
			$this->container->call($registrar, 'boot');
		}
	}

	public function run()
	{
		$response = $this->serve();

		$this->sendStatusCode($response);
		$this->sendHeaders($response);
		$this->printContent($response);
	}

	private function sendStatusCode(Response $response)
	{
		http_response_code($response->getStatusCode());
	}

	private function sendHeaders(Response $response)
	{
		foreach ($response->getHeaders()->all() as $header => $value) {
			header("$header: $value");
		}
	}

	private function printContent(Response $response)
	{
		echo $response->getContent();
	}

	/**
	 * @return Response
	 */
	private function serve(): Response
	{
		$method = '';

		if (array_key_exists('method', $_REQUEST)) {
			$method = $_REQUEST['method'];
		}

		return $this->router()
			->serve($method, $_REQUEST);
	}

	private function router(): Router
	{
		return $this->container->resolve(Router::class);
	}
}