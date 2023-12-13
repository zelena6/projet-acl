<?php

declare(strict_types=1);

/**
 * Classe Player
 * 
 * Correspond au joueur
 */
final class Player
{
    /* @ non_null @ */ public string $userName;

    /**
     * Constructeur du joueur
     * 
     * @param string $userName Le nom du joueur
     */
    /* @ requires $userName != null
    @ */
    public function __construct(string $userName)
    {
        $this->userName = $userName;
    }

    /**
     * Getteur du nom
     */
    /* @ pure @ */
    public function getUsername(): string
    {
        return $this->userName;
    }

    /**
     * Setteur du nom
     * 
     * @param string $userName Le nom
     */
    /* @ requires $userName != null
    @ */
    public function setUsername(string $userName): void
    {
        $this->userName = $userName;
        /** @todo Verifier nom valide */
    }
}
