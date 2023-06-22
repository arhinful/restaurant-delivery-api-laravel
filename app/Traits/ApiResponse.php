<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


trait ApiResponse
{
    protected function success($message, $data = [], $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    protected function successReadCollection($data = []): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => "Items found",
        ];
        $response = array_merge($response, $data);
        return response()->json($response);
    }

    public function error($message, $status = 422): JsonResponse{
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    public function successRead($data = []): JsonResponse{
        return $this->success(
            "Item(s) found",
            $data,
        );
    }

    public function successCreated($data = [], $message = "Item created successfully"): JsonResponse{
        return $this->success(
            $message,
            $data,
            Response::HTTP_CREATED
        );
    }

    public function successUpdated($data = []): JsonResponse{
        return $this->success(
            "Item updated successfully",
            $data,
            Response::HTTP_ACCEPTED
        );
    }

    public function successDeleted(): JsonResponse{
        return $this->success(
            "Item updated successfully",
            Response::HTTP_NO_CONTENT
        );
    }

    public function errorOccurred($message=""): JsonResponse{
        return $this->error(
            "An error occurred, please try again later $message",
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
