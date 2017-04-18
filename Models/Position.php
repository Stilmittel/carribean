<?php

namespace Molab\Carribean\Models;

/**
 * @author Moritz Wachter <moritzwachter@yahoo.de>
 */
class Position {

    /** @var  int $x */
    protected $x;

    /** @var  int $y */
    protected $y;

    /**
     * @param $x
     * @param $y
     */
    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param $x
     * @param $y
     * @return bool
     */
    public function equals($x, $y) {
        return $this->x == $x && $this->y == $y;
    }

    /**
     * @return int
     */
    public function getX() {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY() {
        return $this->y;
    }

    /**
     * @param Position $position
     * @return number
     */
    public function diff(Position $position)
    {
        $diffX = abs($position->getX() - $this->x);
        $diffY = abs($position->getY() - $this->y);

        return $diffX + $diffY;
    }
}