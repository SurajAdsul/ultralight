<?php

namespace Bootstrap;

use Providers\AppServiceProvider;

class RepositoryResolver
{
    /**
     * @var array
     */
    protected $instances = [];

    /**
     * @param $abstract
     * @param null $concrete
     */
    public function set($abstract, $concrete = NULL)
    {
        if ($concrete === NULL) {
            $concrete = $abstract;
        }
        $this->instances[$abstract] = $concrete;
    }

    /**
     * @param $abstract
     * @param array $parameters
     * @return mixed|object
     */
    public function get($abstract, $parameters = [])
    {
        // if we don't have it, just register it
        if (!isset($this->instances[$abstract])) {
            $this->set($abstract);
        }
        return $this->resolve($this->instances[$abstract], $parameters);
    }


    /**
     * resolve single
     *
     * @param $concrete
     * @param $parameters
     * @return mixed|object
     * @throws \Exception
     */
    public function resolve($concrete, $parameters)
    {
        if ($concrete instanceof \Closure) {
            return $concrete($this, $parameters);
        }
        $reflector = new \ReflectionClass($concrete);

        // check if class is instantiable
        if (!$reflector->isInstantiable()) {
            throw new \Exception("Class {$concrete} is not instantiable");
        }
        // get class constructor
        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            // get new instance from class
            return $reflector->newInstance();
        }
        // get constructor params
        $parameters = $constructor->getParameters();

        if (count($parameters) === 0)
            return $reflector->newInstance();

        $dependencies = $this->getDependencies($parameters, $concrete);

        // get new instance with dependencies resolved
        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * get all dependencies resolved
     *
     * @param $parameters
     * @param $concrete
     * @return array
     * @throws \Exception
     */
    public function getDependencies($parameters, $concrete)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            // get the type hinted class
            $dependency = $parameter->getClass();

            if ($dependency === NULL) {
                // check if default value for a parameter is available
                if ($parameter->isDefaultValueAvailable()) {
                    // get default value of parameter
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new \Exception("Can not resolve class dependency {$parameter->name}");
                }
            } else {
                if (isset(AppServiceProvider::REGISTERED_DEPENDENCIES[$concrete]) && empty(class_implements($dependency->name))) {
//                    throw new \Exception("Can not resolve class dependency for {$dependency->name}");

                    $dep = collect(AppServiceProvider::REGISTERED_DEPENDENCIES[$concrete])
                        ->filter(function ($value) use ($dependency) {
                            if (in_array($dependency->name, class_implements($value))) {
                                return TRUE;
                            }
                        })->first();
                } else {
                    $dep = $dependency->name;
                }


                $dependencies[] = $this->get($dep);
            }
        }

        return $dependencies;
    }


}