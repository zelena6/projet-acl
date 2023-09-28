<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PlayerTest extends TestCase
{
    public function testPlayerToJson(): void
    {
        $this->assertSame('{"userName":"test"}', json_encode(new Player("test")));
    }
}
