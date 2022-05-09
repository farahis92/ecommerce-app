<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RouteNotFound extends NotFoundHttpException
{
    public function render()
    {
        return \Respond::respondNotFound(self::getMessage());
    }
}
