<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


/**
 * Class CustomApiException
 *
 * @package App\Exceptions
 */
class CustomApiException extends Exception
{
    public $errorMessage;
    public $errorHttpCode;
    public $errors;

    /**
     * CustomApiException constructor.
     *
     * @param string|null $message
     * @param int $httpCode
     * @param array $errors
     */
    public function __construct($message, int $httpCode = Response::HTTP_BAD_REQUEST, $errors = [])
    {
        parent::__construct($message, $httpCode);
        $this->errorMessage = $message;
        $this->errorHttpCode = $httpCode;
        $this->errors = $errors;
    }


    /**
     *
     */
    public function report()
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {

    }

}
