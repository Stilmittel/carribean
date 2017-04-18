<?php

namespace Molab\Carribean;

use Molab\Carribean\Models\Barrel;
use Molab\Carribean\Models\Cannonball;

/**
 * @author Moritz Wachter <moritzwachter@yahoo.de>
 */
class CannonContainer
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
    public function add($x, $y) {
        $this->container[] = new Cannonball($x, $y);
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
}