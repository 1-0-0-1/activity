<?php

namespace App\EventSubscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AllRequestSubscriber implements EventSubscriberInterface
{

    public function onKernelRequest(RequestEvent $event): void
    {
        $route = $event->getRequest()->get('_route');
        if (
            !empty($route)
            && substr($route, 0, 20) === "json_rpc_http_server"
        ) {
            return;
        }
        die(403);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 1]]
        ];
    }
}
