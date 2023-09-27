<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CardTest extends TestCase
{
    public function testCardToJson(): void
    {
        $this->assertSame('{"color":"black","shape":"clubs","value":"two"}', json_encode(new Card(Color::Black, Shape::Clubs, Value::Two)));
    }
}
