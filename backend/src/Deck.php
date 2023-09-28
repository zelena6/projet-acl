<?php

class Deck
{
    private array $cards;

    function __construct()
    {
        $this->cards = [];

        foreach (Shape::cases() as $shape) {
            foreach (Value::cases() as $value) {
                array_push($this->cards, new Card($shape, $value));
            }
        }
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function setCards(array $cards): void
    {
        $this->cards = $cards;
    }
}
