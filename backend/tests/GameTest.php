<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class Gametest extends TestCase
{

    private $game;

    public function testDrawsCardToJson(): void
    {
        $game = new Game(3);
        for ($i = 0; $i < 20; $i++) {
            echo "indice " . intval($i) . " : " . json_encode($game->drawCard()) . " \n";
        }
    }
}
