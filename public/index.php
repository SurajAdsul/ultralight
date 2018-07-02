<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../vendor/larapack/dd/src/helper.php';

// Remove comment if you want to connect to database.
//require_once __DIR__.'/../bootstrap/database.php';


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

$serviceContainer = include __DIR__.'/../bootstrap/container.php';

$serviceContainer->setParameter('routes', include __DIR__.'/../app/routes.php');

$request = Request::createFromGlobals();

$response = $serviceContainer->get('framework')->handle($request);

$response->send();
