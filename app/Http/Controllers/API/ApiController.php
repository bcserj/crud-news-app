<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ApiController extends Controller
{
    protected function successResponse(
        array|JsonResource $data,
        ?string $message = null,
        $code = HttpResponse::HTTP_OK
    ): JsonResponse {
        $responseData = [
            'success' => true,
        ];

        if (!empty($data)) {
            $responseData['data'] = $data;
        }

        if (is_string($message) && !empty($message)) {
            $responseData['message'] = $message;
        }

        return response()->json($responseData, $code);
    }

    protected function errorResponse(
        ?array $errors,
        ?string $message = null,
        $code = HttpResponse::HTTP_NOT_FOUND
    ): JsonResponse {
        $responseData = [
            'success' => false,
        ];

        if (!empty($errors)) {
            $responseData['errors'] = $errors;
        }

        if (is_string($message) && !empty($message)) {
            $responseData['message'] = $message;
        }

        return response()->json($responseData, $code);
    }
}
