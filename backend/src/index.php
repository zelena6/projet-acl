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

$app->post("/game", function (Request $request, Response $response, $args) {
    // on doit stocker la liste des parties dans un fichier texte car pour chaque
    // nouvelle route chargée = un nouveau contexte donc pas possible d'utiliser
    // de variables globals ):

    $resource = fopen("games.txt", "r");
    if ($resource == false) {
        print("fopen error");
    }

    $games = [];

    if (filesize("games.txt") > 0) {
        $json = fread($resource, filesize("games.txt")); // + 1 pour éviter erreur
        if ($json == false) {
            print("fread error");
        }
        $games = json_decode($json, true);
    }

    $resource = fopen("games.txt", "w");
    if ($resource == false) {
        print("fopen error");
    }

    $username = json_decode($request->getBody(), 1)["username"];
    $games[$username] = new Game(new Player($username));
    // array_push($games, [$username => new Game(new Player($username))]);
    $write_res = fwrite($resource, json_encode($games));
    if ($write_res == false) {
        print("fwrite error");
    }

    return $response;
});


$app->get("/game/{username}", function (Request $request, Response $response, array $args) {
    $username = $args["username"];
    $resource = fopen("games.txt", "r");
    if ($resource == false) {
        print("fopen error");
    }

    $games = [];
    if (filesize("games.txt") > 0) {
        $json = fread($resource, filesize("games.txt")); // + 1 pour éviter erreur
        if ($json == false) {
            print("fread error");
        }
        $games = json_decode($json, true);
    }

    // print_r($games[$username]);
    $response->getBody()->write(json_encode($games[$username]));
    $response = $response->withHeader("Content-Type", "application/json");

    return $response;
});

$app->get("/game/{username}/play", function (Request $request, Response $response, array $args) {
    $username = $args["username"];
    $resource = fopen("games.txt", "r");
    if ($resource == false) {
        print("fopen error");
    }

    $games = [];
    if (filesize("games.txt") > 0) {
        $json = fread($resource, filesize("games.txt")); // + 1 pour éviter erreur
        if ($json == false) {
            print("fread error");
        }
        $games = json_decode($json, true);
    }
    $game = $games[$username];
    // renvoyer deux cartes
    // supprimer les deux cartes du paquet
    // calculer les points
    $response = $response->withHeader("Content-Type", "application/json");

    return $response;
});


// Lance l'application Slim
$app->run();
