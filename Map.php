<?php

namespace Molab\Carribean;

use Molab\Carribean\Models\Mine;

/**
 * @author Moritz Wachter <moritzwachter@yahoo.de>
 */
class Map
{
    protected $mines = array();

    protected $opponentShips = array();

    protected $playerShips = array();

    protected $cannonballs = array();

    public function detect(array $parameters)
    {
        list ($entityId, $entityType, $x, $y, $arg1, $arg2, $arg3, $arg4) = $parameters;



        switch ($entityType)
        {
            case Type::BARREL:
                //handle barrel
                break;

            case Type::SHIP:
                //handle ship
                break;

            case Type::CANNON:
                //handle cannonball
                break;

            case Type::MINE:
                //handle mine
                break;
        }
    }

    /**
     * @param Mine $mine
     */
    public function addMine(Mine $mine)
    {
        $this->mines[] = $mine;
    }

    /**
     * @param Mine $mine
     */
    public function removeMine(Mine $mine)
    {
        foreach ($this->mines as $i => $detectedMine) {
            if ($detectedMine == $mine) {
                unset($this->mines[$i]);
            }
        }
    }
}