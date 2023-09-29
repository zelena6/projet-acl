<?php

interface Rule
{
    function execute(Card $a, Card $b): int;
}
