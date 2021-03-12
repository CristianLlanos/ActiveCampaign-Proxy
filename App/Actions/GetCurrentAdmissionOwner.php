<?php

namespace App\Actions;

use App\Router\Action;
use App\Router\Response;
use App\Router\Responses\PlainTextResponse;

class GetCurrentAdmissionOwner implements Action
{
	public function handle(array $params): Response
	{
		return new PlainTextResponse('GetCurrentAdmissionOwner');
	}
}