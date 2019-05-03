<?php
// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        $message = "";
        $responseCode = Response::HTTP_OK;

        if($exception instanceof NotFoundHttpException) {
            $message = "Not Found";
            $responseCode = Response::HTTP_NOT_FOUND;
        } elseif($exception instanceof BadRequestHttpException) {
            $message = "Please recheck all the parameters and resend again";
            $responseCode = Response::HTTP_NOT_FOUND;
        } else {
            $message = "Something went wrong";
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $response = new JsonResponse(["message"=>$message],$responseCode);
        $event->setResponse($response);
    }
}