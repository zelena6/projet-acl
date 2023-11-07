<?php

define("MAX_TURN", 5);

/**
 * Classe Game
 * 
 * Contient les propriétés d'une partie (nombre de tours, les cartes, ...)
 */
class Game
{
    public int $turn;
    public int $score;
    public ?Player $player;
    public Deck $deck;

    // Constructor
    public function __construct(?Player $player = null)
    {
        $this->turn = 0;
        $this->score = 0;
        $this->player = $player;
        $this->deck = new Deck();
        $this->deck->shuffle();
    }



    // Getter for 'turn'
    public function getTurn(): int
    {
        return $this->turn;
    }

    // Setter for 'turn'
    public function setTurn(int $turn): void
    {
        $this->turn = $turn;
    }

    // Getter for 'score'
    public function getScore(): int
    {
        return $this->score;
    }

    // Setter for 'score'
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * Getteur du joueur
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * Setteur du joueur
     */
    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }

    /**
     * Sauvegarde le score dans la base de données
     */
    public function saveScore(): void
    {
        $db = new SQLite3("database.db");
        $stmt = $db->prepare("insert into scoreboard (username, score) values (?, ?)");
        $stmt->bindParam(1, $this->player->userName, SQLITE3_TEXT);
        $stmt->bindParam(2, $this->score, SQLITE3_INTEGER);
        $stmt->execute();
    }

    /**
     * Calcul le score de 2 cartes en utilisant la chaîne de responsabilité
     * 
     * @param Card $a La première carte
     * @param Card $b La deuxième carte
     * 
     * @return int Le score
     */
    public function calculateScore(Card $a, Card $b)
    {
        $wrongValueWrongColor = new WrongValueWrongColor();
        $goodValueWrongColor = new GoodValueWrongColor();
        $goodValueGoodColor = new GoodValueGoodColor();

        $goodValueGoodColor->setNext($goodValueWrongColor);
        $goodValueWrongColor->setNext($wrongValueWrongColor);

        return $goodValueGoodColor->handle($a, $b);
    }
}
