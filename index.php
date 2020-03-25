<?php
require 'vendor/autoload.php';

$router = new App\Router\Router($_GET['url']);

$router->get('/', "App#index");
$router->get('/user', "User#index");
$router->get('/visite', "Visite#index");
$router->get('/patient', "Patient#index");
$router->post('/user', "User#connexion");
$router->post('/auth', "Auth#connexion");
//$router->get('/posts/:id', "Posts#show");

try {
    $router->run();
} catch (Exception $e) {
    $response = new \App\Core\Http\Response();
    $response->setHTTP($e->getCode(), $e->getMessage(), true);
    $response->exec();
}