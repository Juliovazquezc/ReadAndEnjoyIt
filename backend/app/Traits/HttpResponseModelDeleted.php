<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait HttpResponseModelDeleted 
{
    /**
     * Return a generic message when a model is deleted
     * 
     * @return JsonResponse
     */
    protected function httpResponseModelDeleted() : JsonResponse {
        return response()->json([
            'message' => __('general.model_deleted'),
        ], Response::HTTP_OK);
    }
}
