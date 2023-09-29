<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CardTest extends TestCase
{
    public function testHeartsCardToJson(): void
    {
        $this->assertSame('{"color":"red","shape":"hearts","value":"as"}', json_encode(new Card(Shape::Hearts, Value::As)));
    }

    public function testDiamondsCardToJson(): void
    {
        $this->assertSame('{"color":"black","shape":"diamonds","value":"as"}', json_encode(new Card(Shape::Diamonds, Value::As)));
    }

    public function testClubsCardToJson(): void
    {
        $this->assertSame('{"color":"red","shape":"clubs","value":"as"}', json_encode(new Card(Shape::Clubs, Value::As)));
    }

    public function testSpadesCardToJson(): void
    {
        $this->assertSame('{"color":"black","shape":"spades","value":"as"}', json_encode(new Card(Shape::Spades, Value::As)));
    }
}
