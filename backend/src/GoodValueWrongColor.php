<?php

class GoodValueWrongColor implements Rule
{
    public function execute(Card $a, Card $b): int
    {
        return - ($a->value->value + $b->value->value);
    }
}
