<?php

namespace Molab\Carribean;

use Molab\Carribean\Models\Position;
use Molab\Carribean\Models\Ship;

/**
 * @author Moritz Wachter <moritzwachter@yahoo.de>
 */
class ShipContainer
{
    /** @var Ship[] */
    protected $enemyShips;

    /** @var  Ship[] */
    protected $playerShips;

    public function __construct() {
        $this->enemyShips = [];
        $this->playerShips = [];
    }

    /**
     * @param Ship $ship
     */
    public function addEnemyShip(Ship $ship) {
        $this->enemyShips[] = $ship;
    }

    /**
     * @param Ship $ship
     */
    public function addPlayerShip(Ship $ship) {
        $this->playerShips[] = $ship;
    }

    /**
     * @return array|Ship[]
     */
    public function getPlayerShips()
    {
        return $this->playerShips;
    }

     /**
     * @return array|Ship[]
     */
    public function getEnemyShips()
    {
        return $this->enemyShips;
    }

    /**
     * @param Position $fromPosition
     * @return mixed|Ship|null
     */
    public function getClosestEnemy(Position $fromPosition)
    {
        $closestEnemy = null;
        $mininimalDistance = 10; //@TODO constant

        foreach ($this->enemyShips as $enemy) {
            $diff = $enemy->getPosition()->diff($fromPosition);

            if ($diff < $mininimalDistance) {
                $closestEnemy = $enemy;
                $mininimalDistance = $diff;
            }
        }

        return $closestEnemy;
    }

}