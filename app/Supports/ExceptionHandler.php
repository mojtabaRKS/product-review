<?php namespace App\Supports;

use App\Exceptions\CustomApiException;
use Dotenv\Exception\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class ExceptionHandlingService
 *
 * @package App\Supports
 */
class ExceptionHandler
{
    use  ApiResponse;

    /**
     * @param $e
     * @param string $status
     * @param null $httpCode
     * @return JsonResponse
     */
    public function exceptionHandler($e, $status = "Failed", $httpCode = null): JsonResponse
    {
        if ($e instanceof NotFoundHttpException) {
            return $this->doException($e, $e->getMessage(), $this->getHttpCode(404, $httpCode), $e->getCode(), $status);

        } elseif ($e instanceof NotFoundResourceException) {
            return $this->doException($e, $e->getMessage(), $this->getHttpCode(404, $httpCode), $e->getCode(), $status);

        } elseif ($e instanceof ModelNotFoundException) {
            return $this->doException($e, $e->getMessage(), $this->getHttpCode(404, $httpCode), $e->getCode(), $status);

        } elseif ($e instanceof EntryNotFoundException) {
            return $this->doException($e, $e->getMessage(), $this->getHttpCode(404, $httpCode), $e->getCode(), $status);

        } elseif ($e instanceof AccessDeniedException) {
            return $this->doException($e, $e->getMessage(), $this->getHttpCode(403, $httpCode), $e->getCode(), $status);

        } elseif ($e instanceof ValidationException) {
            return $this->doException($e, $e->getMessage(), $this->getHttpCode(400, $httpCode), $e->getCode(), $status);

        } elseif ($e instanceof AuthorizationException) {
            return $this->doException($e, $e->getMessage(), $this->getHttpCode(403, $httpCode), $e->getCode(), $status);

        } elseif ($e instanceof UnauthorizedException) {
            return $this->doException($e, $e->getMessage(), $this->getHttpCode(403, $httpCode), $e->getCode(), $status);

        } elseif ($e instanceof BadRequestException) {
            return $this->doException($e, $e->getMessage(), $this->getHttpCode(400, $httpCode), $e->getCode(), $status);

        } elseif ($e instanceof HttpResponseException) {
            $message = json_decode($e->getResponse()->getContent(), 1)['meta']['validationErrors'];
            return $this->doException($e, json_encode($message), $this->getHttpCode(400, $httpCode), $e->getCode(), $status);

        } elseif ($e instanceof CustomApiException) {
            return $this->doException($e, $e->getMessage(), $this->getHttpCode(400, $httpCode), $e->getCode(), $status, $e->errors);

        } else {
            $params = ' Product - ' . 'Msg: ' . $e->getMessage() . "{" . $e->getTraceAsString() . "}";
            Log::Error($params);
            return $this->failedResponse();
        }
    }

    /**
     * @param        $e
     * @param        $message
     * @param        $httpCode
     * @param        $statusCode
     * @param string $status
     * @return JsonResponse
     */
    private function doException($e, $message, $httpCode, $statusCode, string $status): JsonResponse
    {
        $params = ' ReviewService - ' . 'Msg: ' . $message . "{" . $e->getTraceAsString() . "}";
        Log::Error($params);
        return $this->customResponse($message, $status, $httpCode, $statusCode);
    }

    private function getHttpCode($defaultHttpCode, $currentHttpCode)
    {
        $httpCode = $defaultHttpCode;
        if (isset($currentHttpCode) && $currentHttpCode != null) {
            $httpCode = $currentHttpCode;
        }
        return $httpCode;
    }
}
