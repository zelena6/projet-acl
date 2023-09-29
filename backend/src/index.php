<?php
// Headers pour autoriser les requêtes cross-origin (CORS)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Crée une instance de l'application Slim
$app = AppFactory::create();

// Définit une route pour la racine ("/")
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write(json_encode(new Card(Shape::Clubs, Value::As)));
    $response = $response->withHeader("Content-Type", "application/json");
    return $response;
});


$app->get('/player', function (Request $request, Response $response, $args) {
    $response->getBody()->write(json_encode(new Player("test")));
    $response = $response->withHeader("Content-Type", "application/json");
    $d = new Deck();
    print("<pre>" . print_r($d->getCards(), true) . "</pre>");
    return $response;
});

// Lance l'application Slim
$app->run();
