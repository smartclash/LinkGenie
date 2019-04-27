<?php

use Server\Controllers\HomeController;
use Server\Controllers\Auth\LoginController;
use Server\Controllers\Auth\RegisterController;
use Server\Controllers\Auth\VerificationController;

$app->get('/', HomeController::class . ':show');

$app->group('/auth', function ($app) {
    $this->get('/login', LoginController::class . ':show');
    $this->get('/register', RegisterController::class . ':show');
    $this->get('/verify', VerificationController::class . ':show');

    $this->post('/login', LoginController::class . ':login');
    $this->post('/register', RegisterController::class . ':register');
})->add('GuestOnlyMiddleware');
