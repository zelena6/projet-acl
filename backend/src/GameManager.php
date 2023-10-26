<?php

class GameManager
{
    private static $instance;
    private $games;

    private function __construct()
    {
        $this->games = [];
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getGames()
    {
        return $this->games;
    }

    public function setGames($games)
    {
        $this->games = $games;
    }
}
