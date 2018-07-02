<?php

namespace Bootstrap;

use \App\Controllers\BaseController;

class ControllerMiddleware
{

    private $controller;
    private $method;
    public $event;

    public function __construct($controller, $method, $event)
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->event = $event;
    }

    /**
     * Execute all middlewares assigned for the controllers
     */
    public function execute()
    {
        $middlewares = $this->getMiddleware();

        if (empty($middlewares)) {
            $this->event->getRequest()->attributes->set('no_token', TRUE);
        }

        foreach ($middlewares as $middleware) {

            $decorator = $this->createMiddlewareDecorator($middleware);

            if ($this->isValidDecorator($decorator)) {

              (new $decorator())->handle($this->event);
            }

        }
    }

    /**
     * @param $middleware
     * @return string
     */
    private static function createMiddlewareDecorator($middleware): string
    {
        return 'App\\Security\\Middleware\\' . $middleware;
    }

    /**
     * @param $decorator
     * @return bool
     */
    private function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }


    /**
     * Get the middleware for the controller instance.
     *
     * @return array
     */
    public function getMiddleware(): array
    {
        if (!method_exists($this->controller, 'getMiddleware')) {
            return [];
        }

        $method = $this->method;

        return collect($this->controller->getMiddleware())->reject(function ($data) use ($method) {
            return static::methodExcludedByOptions($method, $data['options']);
        })->pluck('middleware')->all();
    }


    /**
     * Determine if the given options exclude a particular method.
     *
     * @param  string $method
     * @param  array $options
     * @return bool
     */
    protected static function methodExcludedByOptions($method, array $options): bool
    {
        return (isset($options['only']) && !in_array($method, (array)$options['only'])) ||
            (!empty($options['except']) && in_array($method, (array)$options['except']));
    }


}