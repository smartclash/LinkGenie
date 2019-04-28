<?php

use Server\Controllers\LinkController;
use Server\Controllers\HomeController;

$app->get('/', HomeController::class . ':show');
$app->get('/link', LinkController::class . ':show');

$app->post('/link/new', LinkController::class . ':newLink');

$app->get('/{code}', LinkController::class . ':getLink');