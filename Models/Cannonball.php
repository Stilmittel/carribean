<?php

namespace Molab\Carribean\Models;

class Cannonball extends Barrel
{
    /**
     * @param $x
     * @param $y
     */
    public function __construct($x ,$y)
    {
        $this->position = new Position($x, $y);
    }
}