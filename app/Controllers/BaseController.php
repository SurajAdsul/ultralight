<?php
namespace App\Controllers;

abstract class BaseController
{


    /**
     * The middleware registered on the controller.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * Register middleware on the controller.
     * @param $middleware
     * @param array $options
     * @return ControllerMiddlewareOptions
     */
    public function middleware($middleware, array $options = [])
    {
        foreach ((array) $middleware as $m) {
            $this->middleware[] = [
                'middleware' => $m,
                'options' => &$options,
            ];
        }

        return new ControllerMiddlewareOptions($options);
    }

    /**
     * Get the middleware assigned to the controller.
     *
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }
}