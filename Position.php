<?php

namespace Molab\Carribean;

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
        if (true) {
            error_log(
                sprintf("%s|%s ? %s|%s",
                    $x,
                    $y,
                    $this->x,
                    $this->y
                )
            );
        }
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
}