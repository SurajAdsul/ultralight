<?php

namespace App\Security\Middleware;

use Contracts\Middleware;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class Auth implements Middleware
{

    public function handle(FilterControllerEvent $event)
    {

    }

}