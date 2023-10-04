<?php

declare(strict_types=1);
final class Game
{
    private $maxTour;
    private $tour;
    private $score;
    private $deck;


    /*
        constructeur de la classe Game
        @param int $maxTour
    */
    function __construct(int $maxTour)
    {
        $this->maxTour = $maxTour;
        $this->tour = 0;
        $this->score = 0;
        $this->deck = new Deck();
    }

    /*
        fonction qui permet de piocher 2 cartes dans le deck mélanger et de les supprimer du deck après avoir piocher. 
        La fonction va faire appel à la fonction calculScore pour calculer le score de la combinaison de carte.
        la fonction va augmenter le tour de 1.
        @param int $card1
        @param int $card2
        @return int
    */
    function drawCard(): array
    {
        if (count($this->deck->getCards()) == 0) {
            $this->deck = new Deck();
            echo "Deck rechargé \n";
        }
        $this->deck->shuffle();
        $card1 = $this->deck->getCards()[0];
        $card2 = $this->deck->getCards()[1];
        array_splice($this->deck->getCards(), 0, 2);
        $this->score += $this->cardsResult($card1, $card2);
        $this->nextTurn();
        return [$card1, $card2];
    }

    function nextTurn(): void
    {
        $this->tour++;
    }

    /*
        fonction qui permet de calculer le score de la combinaison de carte en fesant appel au design pattern strategy dans le dossier rules.
        si les deux cates ont la même couleur et la même valeur faire appel a la classe GoodValueGoodColor.php
        si les deux cartes n'ont la même couleur mais la même valeur faire appel a la classe GoodValueWrongColor.php
        si les deux cartes n'ont pas la même valeur et la même couleur faire appel a la classe WrongValueWrongColor.php
        @param Card $card1
        @param Card $card2
        @return int
    */
    function cardsResult(Card $card1, Card $card2): int
    {
        if ($card1->color == $card2->color && $card1->value == $card2->value) {
            $rule = new GoodValueGoodColor();
            $this->score += $rule->execute($card1, $card2);
        } else if ($card1->color != $card2->color && $card1->value == $card2->value) {
            $rule = new GoodValueWrongColor();
            $this->score += $rule->execute($card1, $card2);
        } else {
            $rule = new WrongValueWrongColor();
            $this->score += $rule->execute($card1, $card2);
        }
        return $rule->execute($card1, $card2);
    }

    function getTour(): int
    {
        return $this->tour;
    }

    function getScore(): int
    {
        return $this->score;
    }

    function getDeck(): Deck
    {
        return $this->deck;
    }
}
