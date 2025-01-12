<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use InfyOm\Generator\Utils\ResponseUtil;
use Symfony\Component\HttpFoundation\Response;

class ApiBaseController extends Controller
{
    /**
     * @param string|int $message
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function sendError(
        string $message = 'NG',
        array $data = [],
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse {
        return response()->json(self::formatResponse($statusCode, $message, $data), $statusCode);
    }

    /**
     * @param array $data
     * @param string|int $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function sendSuccess(
        array $data = [],
        string $message = 'OK',
        int $statusCode = Response::HTTP_OK
    ): JsonResponse {
        return response()->json(self::formatResponse($statusCode, $message, $data), $statusCode);
    }

    /**
     * @param int $statusCode
     * @param string $message
     * @param array $data
     * @return array<string, int|string|array>
     */
    public static function formatResponse(int $statusCode, string $message, array $data = []): array
    {
        return [
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data,
        ];
    }
}
