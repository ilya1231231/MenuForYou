<?php

namespace App\Infrastructure\EventSubscribers;

use App\Core\Exceptions\IPublicException;
use App\Core\Exceptions\PublicValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            //поднимаем подписчика вверх, чтобы наше исключение трансформировалось как можно раньше
            //в http-исключение с 422 кодом и не логировалось.
            KernelEvents::EXCEPTION => ['exceptionsTransformer', 300],
        ];
    }

    public function exceptionsTransformer(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $exClass = get_class($exception);
        $interfaces = class_implements($exClass);

        if (!in_array(IPublicException::class, $interfaces)) {
            return;
        }

        switch ($exClass) {
            case  PublicValidationException::class:
                $code = Response::HTTP_UNPROCESSABLE_ENTITY;
                break;
            default :
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $transformedException = new HttpException(
            $code,
            $exception->getMessage(),
        );
        $event->setThrowable($transformedException);

    }
}