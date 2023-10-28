<?php

define("MAX_TURN", 5);

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

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }

    public function saveScore(): void
    {
        $db = new SQLite3("database.db");
        $stmt = $db->prepare("insert into scoreboard (username, score) values (?, ?)");
        $stmt->bindParam(1, $this->player->userName, SQLITE3_TEXT);
        $stmt->bindParam(2, $this->score, SQLITE3_INTEGER);
        $stmt->execute();
    }

    public function calculateScore(Card $a, Card $b)
    {
        $wrongValueWrongColor = new WrongValueWrongColor();
        $goodValueWrongColor = new GoodValueWrongColor();
        $goodValueGoodColor = new GoodValueGoodColor();

        $wrongValueWrongColor->setNext($goodValueWrongColor);
        $goodValueWrongColor->setNext($goodValueGoodColor);

        return $wrongValueWrongColor->handle($a, $b);
    }
}
