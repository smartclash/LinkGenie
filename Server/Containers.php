<?php

use PHPMailer\PHPMailer\PHPMailer;

$container = $app->getContainer();

$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(__DIR__ . '/Views');
    $router = $c->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$container['mail'] = function ($c) {
    $mail = new PHPMailer(false);

    $mail->isSMTP();
    $mail->Host = getenv('MAIL_HOST');
    $mail->SMTPAuth = true;
    $mail->Username = getenv('MAIL_USER');
    $mail->Password = getenv('MAIL_PASS');
    $mail->SMTPSecure = 'tls';
    $mail->Port = (int) getenv('MAIL_PORT');

    $mail->setFrom(getenv('MAIL_FROM'));

    return $mail;
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

$container['auth'] = function($c) use ($container) {
    return new \Delight\Auth\Auth(
        $container->get('db')->pdo
    );
};

$container['GuestOnlyMiddleware'] = function ($c) {
    return new \Server\Middlewares\GuestOnly($c);
};

$container['UserOnlyMiddleware'] = function ($c) {
    return new \Server\Middlewares\UserOnly($c);
};
