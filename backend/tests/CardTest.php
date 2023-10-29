<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CardTest extends TestCase
{
    public function testHeartsCardToJson(): void
    {
        $this->assertSame('{"color":"red","shape":"hearts","value":14}', json_encode(new Card(Shape::Hearts, Value::As)));
    }

    public function testDiamondsCardToJson(): void
    {
        $this->assertSame('{"color":"red","shape":"diamonds","value":14}', json_encode(new Card(Shape::Diamonds, Value::As)));
    }

    public function testClubsCardToJson(): void
    {
        $this->assertSame('{"color":"black","shape":"clubs","value":14}', json_encode(new Card(Shape::Clubs, Value::As)));
    }

    public function testSpadesCardToJson(): void
    {
        $this->assertSame('{"color":"black","shape":"spades","value":14}', json_encode(new Card(Shape::Spades, Value::As)));
    }
}
