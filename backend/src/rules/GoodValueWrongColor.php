
<?php
/**
 * Classe GoodValueWrongColor
 *
 * Cette classe représente une règle pour comparer deux cartes en fonction de leurs valeurs.
 * Elle implémente l'interface Rule et définit la méthode execute pour la règle.
 *
 * @implements Rule
 */
class GoodValueWrongColor extends BaseRule
{
    public function handle(Card $a, Card $b)
    {
        if (
            $this->next == null ||
            ($a->getValue() == $b->getValue()
                && $a->getColor() != $b->getColor())
        ) {
            $scoreA = value::getScore($a->value);
            $scoreB = value::getScore($b->value);

            return - ($scoreA + $scoreB);
        }

        return $this->next->handle($a, $b);
    }
}
