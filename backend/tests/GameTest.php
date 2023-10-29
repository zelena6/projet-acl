<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class Gametest extends TestCase
{
    public function testCalculateScoreGoodValueGoodColor()
    {
        $game = new Game(new Player("test"));
        $score = $game->calculateScore(
            new Card(Shape::Hearts, Value::Ten),
            new Card(Shape::Diamonds, Value::Ten)
        );
        $this->assertSame($score, 40);
    }

    public function testCalculateScoreGoodValueWrongColor()
    {
        $game = new Game(new Player("test"));
        $score = $game->calculateScore(
            new Card(Shape::Spades, Value::Ten),
            new Card(Shape::Diamonds, Value::Ten)
        );
        $this->assertSame($score, -20);
    }

    public function testCalculateScoreWrongValueWrongColor()
    {
        $game = new Game(new Player("test"));
        $score = $game->calculateScore(
            new Card(Shape::Spades, Value::Queen),
            new Card(Shape::Diamonds, Value::Ten)
        );
        $this->assertSame($score, 13);
    }
}
