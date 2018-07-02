# ultralight
A simple microframework for creating REST API's using symfony components


## Request Lifecycle
This is the general overview of how the application has been bootstrapped using Symfony components.

The entry point for all requests to this application is the  `public/index.php`  file. All requests are directed to this file by your web server (  Nginx) configuration. The  `index.php`  file doesn't contain much code. Rather, it is a starting point for loading the rest of the application.

The  `index.php`  file loads the Composer generated autoloader definition, database and then retrieves an instance of the Symfony DI container  from  `bootstrap/container.php`  script. 
`bootstrap/container.php` register other components I have written in the bootstrap directory.
Once it creates the instance of the container then I have registered the route definition for our application. After that our container instance will handle the request and will return the response accordingly. 

## Directory Structure 
 - The Root Directory
    - The  `app`  Directory
    - The  `bootstrap`  Directory
    - The  `contracts`  Directory
    - The  `database`  Directory
    - The  `public`  Directory
    - The  `tests`  Directory
    - The  `vendor`  Directory

- The  `App`  Directory
    - The  `Controllers`  Directory
    - The  `Exception`  Directory
    - The  `Model`  Directory
    - The  `Redirection`  Directory
    - The  `security`  Directory

## Introduction
I have used some Symfony and laravel components to create a minimal framework for creating this application. This framework can be used for writing any RESTful API. 

## The Root Directory

#### The App Directory

The  `app`  directory, as you might expect, contains the core code of the application.
It contains all the domain and business-related logic. I'll explain that code in below section.

#### The Bootstrap Directory

The  `bootstrap`  directory contains the various files which bootstrap the framework. 
It contains the container where all required files are registered in a DI container. It is the heart of the framework. This directory is responsible for initializing the database, controller resolver, repository resolver and handling the responses and middlewares.

#### The Contracts Directory

The `contracts` directory can contain all the interfaces regarding bootstrapping of the application. Currently, it only contains the one contract regarding the middleware.

#### The Database Directory 

The  `database`  directory contains the migration script which can be run against any databases as it utilizes the `Illuminate\Database` component.


#### The Providers Directory 

The  `providers`  directory contains the validation factory and appserviceprovider where you can specify all the controller repositories if you have injected in any controller. Once you define the dependency here framework will automatically resolve it. As I have written the `RepositoryResolver` component in `bootstrap` directory.

#### The Public Directory

The  `public`  directory contains the  `index.php`  file, which is the entry point for all requests entering in our application and configures autoloading.

#### The Tests Directory

The  `tests`  directory contains all your automated tests. You can run your tests using the  `phpunit`  or  `vendor/bin/phpunit`  commands.

#### The Vendor Directory

The  `vendor`  directory contains your  [Composer](https://getcomposer.org/)  dependencies.



## The App Directory

#### The Controllers Directory
This is where all the application controllers are defined.

#### The Exception Directory
This is where all exceptions are being handled and displayed to the user.

#### The Model Directory
This is where all the models have been defined. It also contains some classes related to search functionality. It contains response transformers, traits, and contracts related to business logic.

#### The Redirection Directory
This handles the extra slashes in the URL and redirects to appropriate route.

#### The Security Directory
This handles the extra slashes in the URL and redirects to appropriate route.


#### Components I have used

Used following components. First I have used all the latest Symfony components but due to an older version of PHP in docker image. So I have downgraded the components to version 3.4.

    "symfony/http-foundation": "^4.0", (object-oriented layer for the HTTP specification.)
    "symfony/routing": "^4.0", (For routing the request)
    "symfony/dependency-injection": "^4.0", (For dependecny injection)
    "symfony/http-kernel": "^4.0", (For a structured process of converting a `Request` into a `Response`  
    "illuminate/database": "^5.6", (For database abstraction)
    "illuminate/validation": "^5.6", (Used for validation. I have written validation factory for this.)
    "phpunit/phpunit": "^7.1", (For writing test cases)
    
#### Better alternatives to above components

Laravel also provides the separate components for building your own framework.
Here is the GitHub link for this. https://github.com/illuminate
