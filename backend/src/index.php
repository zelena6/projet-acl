<?php
// Headers pour autoriser les requêtes cross-origin (CORS)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
// Gestion des options CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: *');
    exit(0); // Assurez-vous de quitter le script ici pour empêcher son exécution ultérieure.
}


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
        $data = fread($resource, filesize("games.txt")); // + 1 pour éviter erreur
        if ($data == false) {
            print("fread error");
        }
        $games = unserialize($data);
    }

    $resource = fopen("games.txt", "w");
    if ($resource == false) {
        print("fopen error");
    }

    $username = json_decode($request->getBody(), 1)["username"];
    $games[$username] = new Game(new Player($username));
    // array_push($games, [$username => new Game(new Player($username))]);
    $write_res = fwrite($resource, serialize($games));
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
        $data = fread($resource, filesize("games.txt")); // + 1 pour éviter erreur
        if ($data == false) {
            print("fread error");
        }
        $games = unserialize($data);
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
        $data = fread($resource, filesize("games.txt")); // + 1 pour éviter erreur
        if ($data == false) {
            print("fread error");
        }
        $games = unserialize($data);
    }
    $game = $games[$username];

    if ($game->turn == 5) {
        $game->saveScore();
        unset($games[$username]); // supression partie
    } else {
        $score = $game->calculateScore($game->deck->cards[0], $game->deck->cards[1]);
        $game->score += $score;

        $response->getBody()->write(json_encode(
            [
                "cards" => [
                    $game->deck->cards[0],
                    $game->deck->cards[1]
                ],
                "score" => $score
            ]
        ));

        $game->turn += 1;
        unset($game->deck->cards[0]);
        unset($game->deck->cards[1]);
        $game->deck->cards = array_values($game->deck->cards);

        $games[$username] = $game;

        $resource = fopen("games.txt", "w");
        if ($resource == false) {
            print("fopen error");
        }

        $write_res = fwrite($resource, serialize($games));
        if ($write_res == false) {
            print("fwrite error");
        }
    }

    // renvoyer deux cartes
    // supprimer les deux cartes du paquet
    // calculer les points
    $response = $response->withHeader("Content-Type", "application/json");

    return $response;
});

$app->get("/game/{username}/stop", function (Request $request, Response $response, array $args) {
    $username = $args["username"];
    $resource = fopen("games.txt", "r");
    if ($resource == false) {
        print("fopen error");
    }

    $games = [];
    if (filesize("games.txt") > 0) {
        $data = fread($resource, filesize("games.txt"));
        if ($data == false) {
            print("fread error");
        }
        $games = unserialize($data);
    }
    unset($games[$username]);

    $resource = fopen("games.txt", "w");
    if ($resource == false) {
        print("fopen error");
    }

    $write_res = fwrite($resource, serialize($games));
    if ($write_res == false) {
        print("fwrite error");
    }

    $response = $response->withHeader("Content-Type", "application/json");

    return $response;
});


// Lance l'application Slim
$app->run();
