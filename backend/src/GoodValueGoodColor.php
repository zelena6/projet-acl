<?php

class GoodValueGoodColor implements Rule
{
    public function execute(Card $a, Card $b): int
    {
        return 2 * ($a->value->value + $b->value->value);
    }
}
