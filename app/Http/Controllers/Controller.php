<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use JsonSerializable;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Respond in JSON.
     */
    public function respond(
        Responsable|array|JsonSerializable $data,
        int                                $statusCode = Response::HTTP_OK,
        array                              $headers = []
    ): JsonResponse
    {
        return response()->json($data, $statusCode, $headers);
    }

    /**
     * Respond with a success message.
     */
    public function respondSuccess(string $message = 'Success', int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return $this->respond(['message' => $message], $statusCode);
    }

    /**
     * Respond with an error.
     */
    public function respondError(
        string $message = 'Internal Error',
        int $statusCode = Response::HTTP_BAD_REQUEST
    ): JsonResponse
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $statusCode,
            ],
        ], $statusCode);
    }

    /**
     * Respond with Created.
     *
     */
    public function respondCreated(
        Responsable|array|JsonSerializable $data = [],
        string $message = 'Created'
    ): JsonResponse
    {
        $responseData = [
            'message' => $message,
        ];

        if (! empty($data)) {
            $responseData['data'] = $data;
        }

        return $this->respond($responseData, Response::HTTP_CREATED);
    }

    /**
     * Respond with Updated.
     */
    public function respondUpdated(
        Responsable|array|JsonSerializable $data = [],
        string $message = 'Updated'
    ): JsonResponse
    {
        $responseData = [
            'message' => $message,
        ];

        if (! empty($data)) {
            $responseData['data'] = $data;
        }

        return $this->respond($responseData);
    }

    /**
     * Respond with Deleted.
     */
    public function respondDeleted(
        Responsable|array|JsonSerializable $data = [],
        string $message = 'Deleted'
    ): JsonResponse
    {
        return $this->respondUpdated($data, $message);
    }

    /**
     * Respond with Not Found.
     */
    public function respondNotFound(string $message = 'Not Found'): JsonResponse
    {
        return $this->respondError($message, Response::HTTP_NOT_FOUND);
    }

    /**
     * Response with an Internal Error.
     */
    public function respondInternalError(string $message = 'Internal Error'): JsonResponse
    {
        return $this->respondError($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Response with an Unauthorized error.
     *
     * @throws AuthorizationException
     */
    public function respondUnauthorized()
    {
        throw new AuthorizationException;
    }
}
