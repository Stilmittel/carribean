<?php

namespace Molab\Carribean;

use Molab\Carribean\Models\Enemy;
use Molab\Carribean\Models\Ship;

/**
 * @author Moritz Wachter <moritzwachter@yahoo.de>
 */
class Game
{
    public static function execute()
    {
        // game loop
        while (TRUE)
        {
            $barrels = new BarrelContainer();
            $cannons = new CannonContainer();
            /** @var Enemy[] $enemies */
            $enemies = array();
            $playerShips = array();
            $mines = new MineContainer();

            fscanf(STDIN, "%d",
                $myShipCount // the number of remaining ships
            );
            fscanf(STDIN, "%d",
                $entityCount // the number of entities (e.g. ships, mines or cannonballs)
            );
            for ($i = 0; $i < $entityCount; $i++)
            {
                $parameters = fscanf(STDIN, "%d %s %d %d %d %d %d %d");
                list ($entityId, $entityType, $x, $y, $arg1, $arg2, $arg3, $arg4) = $parameters;

                switch ($entityType)
                {
                    case Type::BARREL:
                        $barrels->add($x, $y, $arg1, $entityId);
                        break;

                    case Type::SHIP:
                        //handle ship
                        if ($arg4 == 1) {
                            $player = new Ship();
                            $player->setPosition($x, $y);
                            $player->setDirection($arg1);
                            $player->setSpeed($arg2);

                            $playerShips[] = $player;
                        } else {
                            $enemy = new Enemy();
                            $enemy->setPosition($x, $y);
                            $enemy->setDirection($arg1);
                            $enemy->setSpeed($arg2);

                            $enemies[$entityId] = $enemy;
                        }
                        break;

                    case Type::CANNON:
                        //handle cannonball
                        $cannons->add($x, $y);
                        break;

                    case Type::MINE:
                        //handle mine
                        $mines->add($x, $y, $entityId);
                        break;
                }

            }

            foreach ($playerShips as $player)
            {
                $barrel = $barrels->getNextBarrel($player->getPosition());

                if ($barrel) {
                    $cmd = sprintf("MOVE %s %s\n",
                        $barrel->getPosition()->getX(),
                        $barrel->getPosition()->getY()
                    );
                }

                $min = 8;
                $closestEnemy = null;

                foreach ($enemies as $enemy) {
                    $diff = $enemy->getPosition()->diff($player->getPosition());

                    if ($diff < $min) {
                        $closestEnemy = $enemy;
                        $min = $diff;
                    }
                }

                if ($closestEnemy != null) {
                    $dir = $closestEnemy->getDirection();
                    $x = $closestEnemy->getPosition()->getX();
                    $y = $closestEnemy->getPosition()->getY();

                    $speed = $closestEnemy->getSpeed();

                    $modifier = ceil((1 + rand(0, 1)) * $speed);

                    if ($dir == 0) {
                        $x += $modifier;
                    } else if ($dir == 1) {
                        $x += $modifier;
                        $y -= $modifier;
                    } else if ($dir == 2) {
                        $x -= $modifier;
                        $y -= $modifier;
                    } else if ($dir == 3) {
                        $x -= $modifier;
                    } else if ($dir == 4) {
                        $x -= $modifier;
                        $y += $modifier;
                    } else if ($dir == 5) {
                        $x += $modifier;
                        $y += $modifier;
                    }

                    $cmd = sprintf("FIRE %s %s\n",
                        abs($x),
                        abs($y)
                    );
                }

//                if ($mine = $mines->getMineToShoot($player->getPosition())) {
//                    $cmd = sprintf("FIRE %s %s\n",
//                        $mine->getPosition()->getX(),
//                        $mine->getPosition()->getY()
//                    );
//                }

                // Write an action using echo(). DON'T FORGET THE TRAILING \n
                // To debug (equivalent to var_dump): error_log(var_export($var, true));

                echo ($cmd); // Any valid action, such as "WAIT" or "MOVE x y"
            }
        }
    }
}