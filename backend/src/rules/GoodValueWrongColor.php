
<?php
/**
 * Classe GoodValueWrongColor
 *
 * Cette classe représente une règle pour comparer deux cartes en fonction de leurs valeurs.
 * Elle implémente l'interface Rule et définit la méthode execute pour la règle.
 *
 * @implements Rule
 */
class GoodValueWrongColor implements Rule
{
    /**
     * Exécute la règle pour comparer deux cartes en fonction de leurs valeurs.
     *
     * @param Card $a La première carte à comparer.
     * @param Card $b La deuxième carte à comparer.
     *
     * @return int Retourne un entier négatif représentant le résultat de la comparaison.
     * Le résultat est calculé comme -(valeur de $a + valeur de $b).
     */
    public function execute(Card $a, Card $b): int
    {
        $scoreA = value::getScore($a->value);
        $scoreB = value::getScore($b->value);

        return - ($scoreA + $scoreB);
    }
}
