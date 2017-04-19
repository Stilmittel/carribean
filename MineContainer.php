<?php

namespace Molab\Carribean;

use Molab\Carribean\Models\Barrel;
use Molab\Carribean\Models\Mine;
use Molab\Carribean\Models\Position;

/**
 * @author Moritz Wachter <moritzwachter@yahoo.de>
 */
class MineContainer
{
    /** @var Barrel[] */
    protected $container;

    public function __construct() {
        $this->container = [];
    }

    /**
     * @param $x
     * @param $y
     */
    public function add($x, $y, $entityId) {
        $this->container[$entityId] = new Mine($x, $y);
    }

    /**
     * @param $x
     * @param $y
     */
    public function remove($x, $y) {
        foreach($this->container as $i => $mine) {
            if ($mine->getPosition()->equals($x, $y)) {
                unset($this->container[$i]);
            }
        }
    }

    /**
     * @param Position $fromPosition
     * @return Barrel|null
     */
    public function getMineToShoot(Position $fromPosition)
    {
        $closestKey = null;
        $minimalDiff = 4;

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