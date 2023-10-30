<?php

/**
 * Classe WrongValueWrongColor
 *
 * Cette classe représente une règle pour comparer deux cartes en fonction de leurs valeurs.
 * Elle implémente l'interface Rule et définit la méthode execute pour la règle.
 *
 */
class WrongValueWrongColor extends BaseRule
{
    public function handle(Card $a, Card $b)
    {
        // verifier si les cartes sont bonnes, si oui retourner valeur, si non passer au handler suivant 
        if (
            $this->next == null || ($a->getValue() != $b->getValue()
                && $a->getColor() != $b->getColor())
        ) {
            $scoreA = Value::getScore($a->value);
            $scoreB = Value::getScore($b->value);

            return $scoreA + $scoreB;
        }

        return $this->next->handle($a, $b);
    }
}
