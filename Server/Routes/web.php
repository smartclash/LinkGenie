<?php

use Server\Controllers\LinkController;
use Server\Controllers\HomeController;

$app->get('/', HomeController::class . ':show')
    ->setName('home');

$app->post('/link/new', LinkController::class . ':newLink')
    ->setName('link.new');

$app->get('/{code}', LinkController::class . ':getLink')
    ->setName('link.show');
