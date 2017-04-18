<?php

namespace Molab\Carribean\Models;

/**
 * @author Moritz Wachter <moritzwachter@yahoo.de>
 */
class Barrel
{
    /** @var Position  */
    protected $position;

    /** @var  int $amount */
    protected $amount;

    /**
     * @param $x
     * @param $y
     * @param $amount
     */
    public function __construct($x, $y, $amount)
    {
        $this->position = new Position($x, $y);
        $this->amount = $amount;
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s|%s|%s", $this->position->getX(), $this->position->getY(), $this->amount);
    }
}