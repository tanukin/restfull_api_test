<?php

namespace App\Exceptions;

use App\Core\Product\Exceptions\ProductException;
use App\Core\Review\Exceptions\ReviewException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ExceptionTrait
{
    public function apiExceptions($request, $exception)
    {
        if ($this->isModel($exception)) {
            return $this->modelResponse();
        }

        if ($this->isHttp($exception)) {
            return $this->httpResponse();
        }

        if ($this->isProductException($exception) || $this->isReviewException($exception)) {
            return $this->exceptionResponse($exception);
        }

        return parent::render($request, $exception);
    }

    protected function isModel($exception): bool
    {
        return $exception instanceof ModelNotFoundException;
    }

    protected function isHttp($exception): bool
    {
        return $exception instanceof NotFoundHttpException;
    }

    protected function isProductException($exception): bool
    {
        return $exception instanceof ProductException;
    }

    protected function isReviewException($exception): bool
    {
        return $exception instanceof ReviewException;
    }

    protected function modelResponse()
    {
        return response()->json([
            'error' => 'Product Model not found'
        ], Response::HTTP_NOT_FOUND);
    }

    protected function httpResponse()
    {
        return response()->json([
            'error' => 'Incorrect route'
        ], Response::HTTP_NOT_FOUND);
    }

    protected function exceptionResponse(Exception $exception)
    {
        return response()->json([
            'error' => $exception->getMessage()
        ], Response::HTTP_BAD_REQUEST);
    }
}