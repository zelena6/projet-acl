<?php

/**
 * Classe WrongValueWrongColor
 *
 * Cette classe représente une règle pour comparer deux cartes en fonction de leurs valeurs.
 * Elle implémente l'interface Rule et définit la méthode execute pour la règle.
 *
 * @implements Rule
 */
class WrongValueWrongColor implements Rule
{
    /**
     * Exécute la règle pour comparer deux cartes en fonction de leurs valeurs.
     *
     * @param Card $a La première carte à comparer.
     * @param Card $b La deuxième carte à comparer.
     *
     * @return int Retourne un entier représentant le résultat de la comparaison.
     * Le résultat est calculé comme la somme des valeurs de $a et $b.
     */
    public function execute(Card $a, Card $b): int
    {
        return $a->value->value + $b->value->value;
    }
}
