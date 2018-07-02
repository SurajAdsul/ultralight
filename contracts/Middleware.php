<?php

namespace Contracts;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

interface Middleware
{
    public function handle(FilterControllerEvent $event);
}