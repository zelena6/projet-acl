<?php

/**
 * Interface Rule
 *
 * Cette interface définit une règle pour comparer deux cartes.
 */
interface Rule
{
    /**
     * Exécute la règle de comparaison entre deux cartes.
     *
     * @param Card $a La première carte à comparer.
     * @param Card $b La deuxième carte à comparer.
     *
     * @return int Un entier négatif si $a est inférieur à $b, zéro si elles sont égales, et un entier positif si $a est supérieur à $b.
     */
    function execute(Card $a, Card $b): int;
}
