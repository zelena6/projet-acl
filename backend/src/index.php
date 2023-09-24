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
    $response->getBody()->write("Je suis ton serveur ! l'index.php");
    return $response;
});

// Lance l'application Slim
$app->run();