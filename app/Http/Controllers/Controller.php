<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Mojtabarks\ApiResponse\ApiResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return JsonResponse
     */
    public function successResponse(string $message, $data = []): JsonResponse
    {
        return ApiResponse::successResponse()
            ->setMessage($message)
            ->setResponseValue($data)
            ->render();
    }

    /**
     * @param string         $message
     * @param Throwable|null $exception
     *
     * @return JsonResponse
     */
    public function failureResponse(string $message, ?Throwable $exception = null): JsonResponse
    {
        $code = Response::HTTP_BAD_REQUEST;

        if (array_key_exists($exception->getCode(), Response::$statusTexts)) {
            $code = $exception->getCode();
        }

        $response = ApiResponse::failureResponse()
            ->setMessage($message)
            ->setCode($code);

        if (config('app.debug')) {
            $response = $response->setResponseValue([
                'Code' => $exception->getCode(),
                'Message' => $exception->getMessage(),
                'File' => $exception->getFile(),
                'Line' => $exception->getLine(),
                'Previous' => $exception->getPrevious(),
                'Trace' => $exception->getTrace(),
            ]);
        }

        Log::critical($exception->getMessage(), $exception->getTrace());

        return $response->render();
    }
}
