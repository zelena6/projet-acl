<?php

/**
 * Classe qui implémente BaseRule
 */
abstract class BaseRule implements Handler
{
    /** @var ?Handler Le prochain maillon */
    protected ?Handler $next = null;

    /**
     * Constructeur par défaut
     */
    public function __construct()
    {
    }

    public function setNext(Handler $next)
    {
        $this->next = $next;
    }

    abstract function handle(Card $a, Card $b);
}
