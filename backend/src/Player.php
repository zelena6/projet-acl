<?php

declare(strict_types=1);
final class Player
{
    public string $userName;

    public function __construct(string $userName)
    {
        $this->userName = $userName;
    }

    public function getUsername(): string
    {
        return $this->userName;
    }
    public function setUsername(string $userName): void
    {
        $this->userName = $userName;
    }
}
