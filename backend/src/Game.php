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
        // print_r($res);
    }

    public function calculateScore()
    {
        $wrongValueWrongColor = new WrongValueWrongColor();
        $goodValueWrongColor = new GoodValueWrongColor();
        $goodValueGoodColor = new GoodValueGoodColor();

        $wrongValueWrongColor->setNext($goodValueWrongColor);
        $goodValueWrongColor->setNext($goodValueGoodColor);

        return $wrongValueWrongColor->handle(new Card(Shape::Clubs, Value::As), new Card(Shape::Clubs, Value::As));
    }
}
