<?php

namespace Molab\Carribean;

use Molab\Carribean\Models\Position;
use Molab\Carribean\Models\Ship;

class Shooter
{
    public static function aimForEnemy(Ship $enemy)
    {
        $dir = $enemy->getDirection();
        $x = $enemy->getPosition()->getX();
        $y = $enemy->getPosition()->getY();

        $speed = $enemy->getSpeed();

        $modifier = (1 * $speed);

        /**
         * default case: we're on an even line
         */
        if ($dir == Directions::E) {
            $x += $modifier;
        } else if ($dir == Directions::W) {
            $x -= $modifier;
        } else if ($dir == Directions::SW) {
            $x -= $modifier;
            $y += $modifier;
        } else if ($dir == Directions::SE) {
            $y += $modifier;
        } else if ($dir == Directions::NE) {
            $y -= $modifier;
        } else if ($dir == Directions::NW) {
            $x -= $modifier;
            $y -= $modifier;
        }

        /**
         * When on an odd line and we're not aiming in a horizontal direction
         */
        $currentY = $enemy->getPosition()->getY();
        if ($currentY % 2 === 1 && $currentY != $y) {
            $x += 1;
        }

        return new Position($x, $y);
    }
}