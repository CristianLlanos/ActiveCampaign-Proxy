<?php

namespace App\Actions;

use App\Repositories\LoadRepository;
use App\Router\Action;
use App\Router\Response;
use App\Router\Responses\PlainTextResponse;

class BalanceAdmissions implements Action
{
	/**
	 * @var LoadRepository
	 */
	private $loads;

	/**
	 * BalanceAdmissions constructor.
	 * @param LoadRepository $loads
	 */
	public function __construct(LoadRepository $loads)
	{
		$this->loads = $loads;
	}

	public function handle(array $params): Response
	{
		$hosts = $this->loads->get();

		$owner = $this->roundRobin($hosts);

		$this->loads->save($hosts);

		$response = new PlainTextResponse($owner);

		$response->withHeader('Cache-Control', 'no-cache; no-store; no-transform');

		return $response;
	}


	private function roundRobin(&$hosts)
	{
		$total = 0;
		$best = null;

		foreach ($hosts as $key => $item) {
			$current = &$hosts[$key];
			$capacity = $current['capacity'];

			$current['availability'] += $capacity;
			$total += $capacity;

			if ($best == null || ($current['availability'] > $hosts[$best]['availability'])) {
				$best = $key;
			}
		}

		$hosts[$best]['availability'] -= $total;
		$hosts[$best]['count'] = ($hosts[$best]['count'] + 1) % 10000;

		return $best;
	}
}