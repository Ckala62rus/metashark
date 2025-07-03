<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends Controller
{
    public function response(
        array $data,
        string $message = "",
        bool $status = true,
        int $statusCode = 200
    ): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
