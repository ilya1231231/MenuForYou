<?php

namespace EventSubscribers\Infrastructure;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
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
        $c = $event->getThrowable();
        $f = 2;
    }
}