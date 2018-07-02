<?php

namespace Bootstrap;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ControllerListener implements EventSubscriberInterface
{

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }
// Strict content type checking
//        if($event->getRequest()->headers->get('content-type') != 'application/json'){
//           throw new HttpException(415,'Invalid content type');
//        }

        (new ControllerMiddleware($controller[0], $controller[1], $event))->execute();
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        // Check middleware set or not
        if ($event->getRequest()->attributes->get('no_token')) {
            return;
        }

        if (!$token = $event->getRequest()->attributes->get('auth_token')) {
            return;
        }

        $response = $event->getResponse();

        $response->headers->set('Authorization', $token);
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::RESPONSE => 'onKernelResponse',
        );
    }

}