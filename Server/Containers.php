<?php

$container = $app->getContainer();

$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(__DIR__ . '/Views');
    $router = $c->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$container['redis'] = function ($c) {
    return new Predis\Client([
        'scheme' => 'tcp',
        'host' => getenv('REDIS_HOST'),
        'port' => getenv('REDIS_PORT')
    ], [
        'parameters' => [
            'password' => getenv('REDIS_PASS')
        ]
    ]);
};

$container['db'] = function($c) {
    return new \Medoo\Medoo([
        'database_type' => getenv('DB_TYPE'),
        'database_name' => getenv('DB_NAME'),
        'server'        => getenv('DB_HOST'),
        'username'      => getenv('DB_USER'),
        'password'      => getenv('DB_PASS'),
        'charset'       => 'utf8',
    ]);
};

$container['CheckCacheMiddleware'] = function($c) {
    return new \Server\Middlewares\CheckCache($c);
};
