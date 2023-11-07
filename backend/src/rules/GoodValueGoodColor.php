<?php

/**
 * Classe GoodValueGoodColor
 *
 * Cette classe implémente l'interface Rule et définit une règle de comparaison
 * basée sur la valeur et la couleur des cartes.
 * 
 */
class GoodValueGoodColor extends BaseRule
{
    public function handle(Card $a, Card $b)
    {
        if (
            $this->next == null ||
            ($a->getValue() == $b->getValue()
                && $a->getColor() == $b->getColor())
        ) {
            $scoreA = value::getScore($a->value);
            $scoreB = value::getScore($b->value);

            return - (2 * ($scoreA + $scoreB));
        }

        return $this->next->handle($a, $b);
    }
}
