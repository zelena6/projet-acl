<?php

define("MAX_TURN", 5);

class Game
{
    private int $turn;
    private int $score;
    private Rule $rule;
    private Player $player;

    // Constructor
    public function __construct(
        int $turn,
        int $score,
        Rule $rule,
        Player $player
    ) {
        $this->turn = $turn;
        $this->score = $score;
        $this->rule = $rule;
        $this->player = $player;
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

    // Getter for 'rule'
    public function getRule(): Rule
    {
        return $this->rule;
    }

    // Setter for 'rule'
    public function setRule(Rule $rule): void
    {
        $this->rule = $rule;
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
        $scoreboard_dao = new ScoreboardDAO();
        $scoreboard_dao->insert($this->player, $this->score);
    }

    public function calculateScore(Card $a, Card $b): int
    {
        if (
            $a->getValue() == $b->getValue()
            && $a->getColor() == $b->getColor()
        ) {
            $this->setRule(new GoodValueGoodColor($a, $b));
        } else if (
            $a->getValue() == $b->getValue()
            && $a->getColor() != $b->getColor()
        ) {
            $this->setRule(new GoodValueWrongColor($a, $b));
        } else if (
            $a->getValue() != $b->getValue()
            && $a->getColor() != $b->getColor()
        ) {
            $this->setRule(new WrongValueWrongColor($a, $b));
        }

        return $this->rule->execute($a, $b);
    }
}
