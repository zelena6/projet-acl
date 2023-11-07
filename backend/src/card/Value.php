<?php

enum Value: int
{
    case Seven = 7;
    case Height = 8;
    case Nine = 9;
    case Ten = 10;
    case Valet = 11;
    case Queen = 12;
    case King = 13;
    case As = 14;

    public static function getScore(self $value): int
    {
        switch ($value) {

            case self::Seven:
                return 7;
            case self::Height:
                return 8;
            case self::Nine:
                return 9;
            case self::Ten:
                return 10;
            case self::Valet:
                return 2;
            case self::Queen:
                return 3;
            case self::King:
                return 4;
            case self::As:
                return 11;
            default:
                return 0; // Par défaut, le score est 0 pour les autres valeurs.
        }
    }
}
