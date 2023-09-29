<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CardTest extends TestCase
{
    public function testCardToJson(): void
    {
        $this->assertSame('{"color":"black","shape":"clubs","value":"as"}', json_encode(new Card(Shape::Clubs, Value::As)));
    }
}
