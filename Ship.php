<?php

namespace Molab\Carribean;

/**
 * @author Moritz Wachter <moritzwachter@yahoo.de>
 */
class Ship
{
    /** Position $position */
    protected $position;

    /** @var  int $direction */
    protected $direction;

    /**
     * @param $x
     * @param $y
     */
    public function setPosition($x, $y) {
        $this->position = new Position($x, $y);
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $dir
     */
    public function setDirection($dir)
    {
        $this->direction = $dir;
    }

    /**
     * @return int
     */
    public function getDirection()
    {
        return $this->direction;
    }
}