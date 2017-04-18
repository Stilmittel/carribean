<?php

namespace Molab\Carribean\Models;

/**
 * @author Moritz Wachter <moritzwachter@yahoo.de>
 */
class Ship
{
    /** Position $position */
    protected $position;

    /** @var  int $direction */
    protected $direction;

    /** @var  int $speed */
    protected $speed;

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

    /**
     * @param $arg2
     */
    public function setSpeed($arg2)
    {
        $this->speed = $arg2;
    }

    /**
     * @return int
     */
    public function getSpeed()
    {
        return $this->speed;
    }
}