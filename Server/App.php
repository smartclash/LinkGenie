<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\App;

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv->load();

$app = new App([
    'settings' => [
        'displayErrorDetails' => getenv('ENVIRONMENT') == 'development' ? true : false
    ],
]);

require __DIR__ . '/Containers.php';
require __DIR__ . '/Routes/web.php';
