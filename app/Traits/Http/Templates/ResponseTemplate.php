<?php

namespace App\Traits\Http\Templates;

use App\Exceptions\HttpResponseAsJsonException;
use App\Utils\ErrorCode;
use App\Utils\ErrorData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

trait ResponseTemplate
{
    public function getPermissions(): array
    {
        return [];
    }

    public function successResponse(
        int $status = 200,
        string $message = '',
        array|object $result = [],
        bool $withPermissions = false,
        array $headers = [],
        int $options = 0
    ): JsonResponse {
        $data = [
            'status' => $status,
            'message' => $message,
            'result' => (object) $result,
        ];

        if ($withPermissions) {
            $data['permissions'] = (object) $this->getPermissions();
        }

        return response()->json($data, $status, $headers, $options);
    }

    public function noContentResponse(array $headers = []): JsonResponse
    {
        return response()->json([], 204, $headers);
    }

    public function errorResponse(
        $status,
        array $errors = [],
        array $headers = [],
        int $options = 0
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'errors' => $errors,
        ], $status, $headers, $options);
    }

    public function httpErrorResponse(HttpResponseAsJsonException $exception): JsonResponse
    {
        return $this->errorResponse(
            $exception->getStatus(),
            $exception->getErrors(),
        );
    }

    public function internalErrorResponse(Throwable $exception): JsonResponse
    {
        $errorWithCode = new ErrorData(ErrorCode::INTERNAL, $exception->getMessage());

        return $this->errorResponse(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            [
                $errorWithCode,
            ],
        );
    }
}
