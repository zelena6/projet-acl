<?php

interface Handler
{
    function setNext(Handler $h);
    function handle(Card $a, Card $b);
}
