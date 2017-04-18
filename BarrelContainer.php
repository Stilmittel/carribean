<?php

namespace Molab\Carribean;

/**
 * @author Moritz Wachter <moritzwachter@yahoo.de>
 */
class BarrelContainer
{
    /** @var Barrel[] */
    protected $container;

    public function __construct() {
        $this->container = [];
    }

    /**
     * @param $x
     * @param $y
     * @param $amount
     */
    public function addBarrel($x, $y, $amount) {
        $this->container[] = new Barrel($x, $y, $amount);
    }

    /**
     * @param $x
     * @param $y
     * @return Barrel
     */
    public function getNextBarrel($x, $y) {
        return $this->getClosestBarrel($x, $y);
    }

    /**
     * @param $x
     * @param $y
     */
    public function removeBarrel($x, $y) {
        foreach($this->container as $i => $barrel) {
            if ($barrel->getPosition()->equals($x, $y)) {
                unset($this->container[$i]);
            }
        }
    }

    /**
     * @param $x
     * @param $y
     *
     * @return Barrel
     */
    public function getClosestBarrel($x, $y)
    {
        $closestKey = null;
        $minimalDiff = 1000;

        foreach ($this->container as $i => $barrel) {
            $diffX = abs($barrel->getPosition()->getX() - $x);
            $diffY = abs($barrel->getPosition()->getY() - $y);

            $diff = $diffX + $diffY;

            if ($diff < $minimalDiff) {
                $closestKey = $i;
            }
        }

        return $this->container[$i];
    }
}