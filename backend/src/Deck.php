<?php

/**
 * Représente un paquet de cartes.
 */
class Deck
{
    /** @var array Tableau de cartes dans le paquet. */
    /* @ non_null @*/ public array $cards;

    /**
     * Constructeur de la classe Deck.
     */
    function __construct()
    {
        $this->cards = [];
        foreach (Shape::cases() as $shape) {
            foreach (Value::cases() as $value) {
                array_push($this->cards, new Card($shape, $value));
            }
        }
    }

    /**
     * Obtient les cartes du paquet.
     *
     * @return array Le tableau de cartes dans le paquet.
     */
    /* @ pure @ */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * Définit les cartes du paquet.
     *
     * @param array $cards Le tableau de cartes à définir dans le paquet.
     */
    /* @ requires $cards != null;
         ensures (\old($cards) == $cards); 
    @ */
    public function setCards(array $cards): void
    {
        $this->cards = $cards;
    }

    /**
     * Mélange les cartes dans le paquet.
     */
    public function shuffle(): void
    {
        for ($i = 0; $i < sizeof($this->cards); $i++) {
            $r = rand(0, sizeof($this->cards) - 1);
            [$this->cards[$i], $this->cards[$r]] = [$this->cards[$r], $this->cards[$i]];
        }
    }
}
