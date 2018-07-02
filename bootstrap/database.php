<?php

// use App\Eloquent\User;
// use App\Eloquent\UserEncapsulated;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

/**
 * Illuminate/database, aka Eloquent, can be used via Capsule.
 * and also a class-encapsulated option
 *
 * Requires: illuminate/database
 *
 * @source https://github.com/illuminate/database
 */


$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'root',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
// use Illuminate\Events\Dispatcher;
// use Illuminate\Container\Container;
// $capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();