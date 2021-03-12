<?php

namespace App;

use App\Repositories\LoadRepository;

class LoadBalancer
{
	/**
	 * @var LoadRepository
	 */
	private $loads;

	/**
	 * LoadBalancer constructor.
	 * @param LoadRepository $loads
	 */
	public function __construct(LoadRepository $loads)
	{
		$this->loads = $loads;
	}

	public function serve(): string
	{
		$hosts = $this->loads->get();

		$owner = $this->roundRobin($hosts);

		$this->loads->save($hosts);

		return $owner;
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