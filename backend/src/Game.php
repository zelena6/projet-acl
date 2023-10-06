<?php

define("MAX_TURN", 5);

class Game
{
    private int $turn;
    private int $score;
    private Rule $rule;
    private Player $player;
    private Deck $deck;

    // Constructor
    public function __construct(
        Player $player
    ) {
        $this->turn = 0;
        $this->score = 0;
        $this->rule = new GoodValueGoodColor();
        $this->player = $player;
        $this->deck = new Deck();
        $this->deck->shuffle();
        // faire en sorte $this->deck = new Deck()->shuffle();
    }

    // Getter for 'turn'
    public function getTurn(): int
    {
        return $this->turn;
    }

    // Setter for 'turn'
    public function setTurn(int $turn): void
    {
        $this->turn = $turn;
    }

    /*
    Fonction qui permet de piocher 2 cartes dans le deck mélangé et de les supprimer du deck après les avoir piochées.
    La fonction fera appel à la fonction calculScore pour calculer le score de la combinaison de cartes.
    La fonction augmentera le turn de 1.
    @return array Un tableau contenant les 2 cartes piochées.
*/
    function drawCard(): array
    {
        if ($this->turn == MAX_TURN) {
            echo "Vous avez atteint le nombre de turn maximum votre score est de : " . $this->getScore();
            return [];
        } else {
            $cards = $this->deck->getCards(); // Obtenir une copie des cartes du deck

            // Si il n'y a plus de carte dans le deck, afficher un message d'erreur
            if (sizeof($cards) == 0) {
                echo "Il n'y a plus de carte dans le deck";
                return [];
            }

            $card1 = array_shift($cards); // Piocher la première carte et la retirer du tableau
            $card2 = array_shift($cards); // Piocher la deuxième carte et la retirer du tableau
            $this->score += $this->cardsResult($card1, $card2);
            $this->nextTurn();

            // Mettre à jour les cartes restantes dans le deck
            $this->deck->setCards($cards);

            echo "Carte 1 : " . json_encode($card1) . "\n";
            echo "Carte 2 : " . json_encode($card2) . "\n";

            echo $this->toStringEtatDuJeu();

            return [$card1, $card2];
        }
    }

    function toStringEtatDuJeu(): string
    {
        return "Tour : " . $this->turn . " Score : " . $this->score . "\n";
    }


    function nextTurn(): void
    {
        $this->turn++;
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
        } else if ($card1->color != $card2->color && $card1->value == $card2->value) {
            $rule = new GoodValueWrongColor();
        } else {
            $rule = new WrongValueWrongColor();
        }
        return $rule->execute($card1, $card2);
    }

    function getTour(): int
    {
        return $this->turn;
    }

    function getScore(): int
    {
        return $this->score;
    }

    // Setter for 'score'
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    // Getter for 'rule'
    public function getRule(): Rule
    {
        return $this->rule;
    }

    // Setter for 'rule'
    public function setRule(Rule $rule): void
    {
        $this->rule = $rule;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }

    public function saveScore(): void
    {
        $scoreboard_dao = new ScoreboardDAO();
        $scoreboard_dao->insert($this->player, $this->score);
    }

    public function calculateScore(Card $a, Card $b): int
    {
        if (
            $a->getValue() == $b->getValue()
            && $a->getColor() == $b->getColor()
        ) {
            $this->setRule(new GoodValueGoodColor($a, $b));
        } else if (
            $a->getValue() == $b->getValue()
            && $a->getColor() != $b->getColor()
        ) {
            $this->setRule(new GoodValueWrongColor($a, $b));
        } else if (
            $a->getValue() != $b->getValue()
            && $a->getColor() != $b->getColor()
        ) {
            $this->setRule(new WrongValueWrongColor($a, $b));
        }

        return $this->rule->execute($a, $b);
    }

    function getDeck(): Deck
    {
        return $this->deck;
    }
}
