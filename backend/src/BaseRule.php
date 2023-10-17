<?php

abstract class BaseRule implements Handler
{
    protected ?Handler $next = null;

    public function __construct()
    {
    }

    public function setNext(Handler $next)
    {
        $this->next = $next;
    }

    abstract function handle(Card $a, Card $b);
}
