<?php

namespace App;

use App\Actions\BalanceAdmissions;
use App\Actions\GetCurrentAdmissionOwner;
use App\Middlewares\ConfiguresCors;
use App\Middlewares\HandlesErrors;
use App\Middlewares\RespondsOptionsRequests;
use App\Router\Router;

class Routes
{
	public function register(Router $router)
	{
		$router->add('meetingScheuled', BalanceAdmissions::class);
		$router->add('getNextMeeting', GetCurrentAdmissionOwner::class);
	}

	public function middleware(Router $router)
	{
		$router->pipe(HandlesErrors::class);
		$router->pipe(ConfiguresCors::class);
		$router->pipe(RespondsOptionsRequests::class);
	}
}