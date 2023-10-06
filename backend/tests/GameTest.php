<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class Gametest extends TestCase
{

    public function testDrawsCardToJson(): void
    {
        $game = new Game(2);
        $game->drawCard();
        $game->drawCard();
        $game->drawCard();
    }
}
