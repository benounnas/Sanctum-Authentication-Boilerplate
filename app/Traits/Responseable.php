<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait Responseable
{

    protected bool $errors = false;

    /**
     * @return User|Authenticatable|null
     */
    protected  function currentUser(): User|Authenticatable|null
  {
        return auth()->user();
    }


    protected function jsonResponse(mixed $data, int $status = 200): JsonResponse
    {
        return response()->json($data, $status);
    }

    protected function successResponse(string $message, mixed $resource = null): JsonResponse
    {
        $response = [
            'message' => $message,
            "data"=> $resource
        ];

        return $this->jsonResponse($response);
    }


    protected function errorResponse(string $message, int $code = null, mixed $data = null): JsonResponse
    {
        $response = [
            'message' => $message,
            'errors' => true,
            'data' => $data,
        ];

        if ($code) {
            $response['code'] = $code;
            return $this->jsonResponse($response, $code);
        }
        return $this->jsonResponse($response);
    }


    protected function authResponse(int $status = 200, bool|string $error = false, mixed $token = null): JsonResponse
    {
        switch ($status) {
            case 200:
                $user = $this->currentUser();
                return $this->jsonResponse(compact('token','user'));
            case 403:
            case 404:
            case 500:
            case 400:
                return $this->jsonResponse(compact('error'), $status);
            case 401:
                return $this->jsonResponse(compact('token'));
        }

        return $this->jsonResponse(['error' => 'Internal Server Error'], 500);
    }

}
