<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait HttpResponseFailure 
{
    
    /**
     * Return a json response object when something fails
     * 
     * @return JsonResponse
     * 
     */
    protected function httpResponseFailure($message, $status = Response::HTTP_UNPROCESSABLE_ENTITY) : JsonResponse {
        return response()->json([
            'message' => $message,
        ],  $status);
    }
}