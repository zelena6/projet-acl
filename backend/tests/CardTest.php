<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CardTest extends TestCase
{
    public function testHeartsCardToJson(): void
    {
        $this->assertSame('{"color":"red","shape":"hearts","value":"two"}', json_encode(new Card(Shape::Hearts, Value::Two)));
    }

    public function testDiamondsCardToJson(): void
    {
        $this->assertSame('{"color":"black","shape":"diamonds","value":"two"}', json_encode(new Card(Shape::Diamonds, Value::Two)));
    }

    public function testClubsCardToJson(): void
    {
        $this->assertSame('{"color":"red","shape":"clubs","value":"two"}', json_encode(new Card(Shape::Clubs, Value::Two)));
    }

    public function testSpadesCardToJson(): void
    {
        $this->assertSame('{"color":"black","shape":"spades","value":"two"}', json_encode(new Card(Shape::Spades, Value::Two)));
    }
}
