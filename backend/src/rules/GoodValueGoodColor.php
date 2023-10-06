<?php

/**
 * Classe GoodValueGoodColor
 *
 * Cette classe implémente l'interface Rule et définit une règle de comparaison
 * basée sur la valeur et la couleur des cartes.
 */
class GoodValueGoodColor implements Rule
{
    /**
     * Exécute la règle de comparaison entre deux cartes.
     *
     * @param Card $a La première carte à comparer.
     * @param Card $b La deuxième carte à comparer.
     *
     * @return int le double de la somme des cartes
     */
    public function execute(Card $a, Card $b): int
    {
        $scoreA = value::getScore($a->value);
        $scoreB = value::getScore($b->value);

        return 2 * ($scoreA + $scoreB);
    }
}
