<?php

/**
 * Classe GameManager
 * 
 * S'occupe des parties en cours
 * 
 * C'est une classe singleton (1 seule instance qui gère toute les parties)
 */
class GameManager
{
    /** @var $instance L'unique instance GameManager */
    private static $instance;
    /** @var $games Les parties en cours */
    private $games;

    /**
     * Constructeur privé
     */
    private function __construct()
    {
        $this->games = [];
    }

    /**
     * Permet d'instancier une unique fois
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Getteur des parties
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Setteur des parties
     * 
     * @param $games Les parties
     */
    public function setGames($games)
    {
        $this->games = $games;
    }
}
