<?php

/**
 * Chaîne de responsabilié pour gérer les différentes règles
 */
interface Handler
{
    /**
     * Sert pour mettre le prochain maillon
     * 
     * @param Handler $h Le maillon suivant
     */
    function setNext(Handler $h);

    /**
     * Essaye d'appliquer la règle, et si n'y arrive pas l'applique au prochain expert
     * 
     * @param Card $a La première carte
     * @param Card $b La deuxième carte
     */
    function handle(Card $a, Card $b);
}
