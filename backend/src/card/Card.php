<?php

/**
 * Classe Carte
 * 
 * Une carte possède une couleur, une forme et une valeur
 */
class Card
{
    public Color $color;
    public Shape $shape;
    public Value $value;

    /**
     * Create a new card
     * 
     * @param   Color   the color of the card
     * @param   Shape   the shape of the card
     * @param   Value   the value of the card
     * @return  Card    the new card
     */
    function __construct(Shape $shape, Value $value)
    {
        $this->color = match ($shape) {
            Shape::Diamonds => Color::Red,
            Shape::Spades => Color::Black,
            Shape::Hearts => Color::Red,
            Shape::Clubs => Color::Black,
        };
        $this->shape = $shape;
        $this->value = $value;
    }

    /**
     * Return the color of the card
     * 
     * @return  Color   the color of the card
     */
    /* @ pure @ */
    function getColor(): Color
    {
        return $this->color;
    }

    /**
     * Set the color of the card
     * 
     * @param   Color   the new color of the card
     * @return  void
     */
    /* @ requires $color != null; */
    function setColor(Color $color): void
    {
        $this->color = $color;
    }

    /**
     * Return the shape of the card
     * 
     * @return  Shape   the shape of the card
     */
    /* @ pure @ */
    function getShape(): Shape
    {
        return $this->shape;
    }

    /**
     * Set the shape of the card
     * 
     * @param   Shape   the new shape of the card
     * @return  void
     */
    /* @ requires $shape != null; */
    function setShape(Shape $shape): void
    {
        $this->shape = $shape;
    }

    /**
     * Return the value of the card
     * 
     * @return  Value   the value of the card
     */
    /* @ pure @ */
    function getValue(): Value
    {
        return $this->value;
    }

    /**
     * Set the value of the card
     * 
     * @param   Value   the new valeu of the card
     * @return  void 
     */
    /* @ requires $color != value; */
    function setValue(Value $value): void
    {
        $this->value = $value;
    }
}
