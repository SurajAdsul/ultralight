<?php

namespace Bootstrap;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;


class ResponseListener implements EventSubscriberInterface
{
    public function onView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();
        $response = new \stdClass();
        $response->success = true;
        $response->data = $result ?: [];

        $event->setResponse(new Response(json_encode($response), 200, array('content-type' => 'application/json')));
    }

    public static function getSubscribedEvents()
    {
        return array('kernel.view' => 'onView');
    }
}