<?php

namespace App\Services;

use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
use Symfony\Component\HttpFoundation\Response;


class ApiResponse
{
    /**
     * @var string
     */
    public string $defaultSuccessMessage = "Success";
    /**
     * @var string
     */
    public string $defaultErrorMessage = "Error";

    /**
     * Default Success Response, Can Custom Data or ApiCode and Message
     * Default Api Code is 200
     *
     * @param mixed|null $data
     * @param null $message
     * @param null $apiCode
     * @return Response
     *
     *
     */
    public function respondSuccess(mixed $data = null, $message = null, $apiCode = null): Response
    {
        return RB::asSuccess($apiCode ?? RESPONSE::HTTP_OK)
            ->withHttpCode($apiCode ?? RESPONSE::HTTP_OK)
            ->withData($data)
            ->withMessage($message ?? $this->defaultSuccessMessage)
            ->build();

    }

    /**
     * Response ok 200
     * @param $data
     * @param $message
     * @return Response
     */
    public function respondOk($data = null, $message = null): Response
    {
        return RB::asSuccess(RESPONSE::HTTP_OK)
            ->withHttpCode(RESPONSE::HTTP_OK)
            ->withData($data)
            ->withMessage($message ?? $this->defaultSuccessMessage)
            ->build();
    }

    /**
     * Response Created 201.
     * @param $data
     * @param $message
     * @return Response
     *
     */
    public function respondCreated($data = null, $message = null): Response
    {
        return RB::asSuccess(RESPONSE::HTTP_CREATED)
            ->withHttpCode(RESPONSE::HTTP_CREATED)
            ->withData($data)
            ->withMessage($message ?? $this->defaultSuccessMessage)
            ->build();
    }

    /**
     * Response no Content 204
     * @return Response
     */
    public function respondNoContent(): Response
    {
        return RB::asSuccess(RESPONSE::HTTP_NO_CONTENT)
            ->withHttpCode(RESPONSE::HTTP_NO_CONTENT)
            ->build();
    }

    /**
     * Response Error Message & ApiCode
     * HTTP_BAD_REQUEST 400 as Default
     *
     * @param string|null $message
     * @param int|null $apiCode = 400
     * @return Response
     */
    public function respondError($message = null, $apiCode = null): Response
    {
        return RB::asError($apiCode ?? RESPONSE::HTTP_BAD_REQUEST)
            ->withHttpCode($apiCode ?? RESPONSE::HTTP_BAD_REQUEST)
            ->withMessage($message ?? $this->defaultErrorMessage)
            ->build();
    }

    /**
     * Response Not Found 404
     *
     * @param string|null $message
     *
     * @return Response
     */
    public function respondNotFound($message = null): Response
    {
        return RB::asError(RESPONSE::HTTP_NOT_FOUND)
            ->withHttpCode(RESPONSE::HTTP_NOT_FOUND)
            ->withMessage($message ?? $this->defaultErrorMessage)
            ->build();
    }

    /**
     * Response Unauthorized or Unauthenticated 401
     *
     * @param string|null $message
     *
     * @return Response
     */
    public function respondUnauthorized(string $message = null): Response
    {
        return RB::asError(RESPONSE::HTTP_UNAUTHORIZED)
            ->withHttpCode(RESPONSE::HTTP_UNAUTHORIZED)
            ->withMessage($message ?? $this->defaultErrorMessage)
            ->build();
    }


    /**
     * Response Forbidden 403 : You don’t have permission to access
     *
     * @param string|null $message
     *
     * @return Response
     */
    public function respondForbidden(string $message = null): Response
    {
        return RB::asError(RESPONSE::HTTP_FORBIDDEN)
            ->withHttpCode(RESPONSE::HTTP_FORBIDDEN)
            ->withMessage($message ?? $this->defaultErrorMessage)
            ->build();
    }

}
