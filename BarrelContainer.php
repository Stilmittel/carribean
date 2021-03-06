<?php

namespace Molab\Carribean;

use Molab\Carribean\Models\Barrel;
use Molab\Carribean\Models\Position;

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
    public function add($x, $y, $amount, $entityId) {
        $this->container[$entityId] = new Barrel($x, $y, $amount);
    }

    /**
     * @param Position $position
     * @return Barrel
     */
    public function getNextBarrel(Position $position) {
        return $this->getClosestBarrel($position);
    }

    /**
     * @param $x
     * @param $y
     */
    public function remove($x, $y) {
        foreach($this->container as $i => $barrel) {
            if ($barrel->getPosition()->equals($x, $y)) {
                unset($this->container[$i]);
            }
        }
    }

    /**
     *
     * @param Position $fromPosition
     * @return Barrel
     */
    public function getClosestBarrel(Position $fromPosition)
    {
        $closestKey = null;
        $minimalDiff = 1000;

        foreach ($this->container as $i => $barrel) {
            $diff = $barrel->getPosition()->diff($fromPosition);

            if ($diff < $minimalDiff) {
                $closestKey = $i;
                $minimalDiff = $diff;
            }
        }

        if (array_key_exists($closestKey, $this->container)) {
            return $this->container[$closestKey];
        }

        return null;
    }
}