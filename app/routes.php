<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();


$routes->add('instructions', new Route(
    '/',
    array('_controller' => 'App\\Controllers\\Controller::index'))
);

$routes->add(
    'remove_trailing_slash',
    new Route(
        '/{url}',
        array(
            '_controller' => 'App\\Redirection\\RedirectingController::removeTrailingSlash',
        ),
        array(
            'url' => '.*/$',
        )
    )
);

return $routes;

?>