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