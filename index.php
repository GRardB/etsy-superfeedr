<?php

require 'vendor/autoload.php';

$app = new \Slim\Slim([
    'templates.path' => 'templates'
]);

$app->get('/', function () use ($app) {
    $app->render('home.php');
});

$app->get('/isotope', function() use ($app) {
    $app->render('isotope.js');
});

$app->get('/poll', function() use ($app) {
    echo exec('tail listings');
});

$app->get('/callback', function () use ($app) {
    echo $app->request->get('hub_challenge');
});

$app->post('/callback', function () use ($app) {
    $update = $app->request->getBody();
    $xml = simplexml_load_string($update);

    $links = $xml->entry->link;
    foreach ($links as $link) {
        if (strpos($link['href'], '570xN') !== false) {
            file_put_contents('listings', $link['href'] . "\n", FILE_APPEND);
            return;
        }
    }
});

$app->run();
