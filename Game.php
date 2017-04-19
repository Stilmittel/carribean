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
        while (TRUE)
        {
            $barrels = new BarrelContainer();
            $cannons = new CannonContainer();
            $ships = new ShipContainer();
            $mines = new MineContainer();
            $lastCommand = array();

            fscanf(STDIN, "%d", $myShipCount);
            fscanf(STDIN, "%d",$entityCount);

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

                            $ships->addPlayerShip($player);
                        } else {
                            $enemy = new Enemy();
                            $enemy->setPosition($x, $y);
                            $enemy->setDirection($arg1);
                            $enemy->setSpeed($arg2);

                            $ships->addEnemyShip($enemy);
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

            foreach ($ships->getPlayerShips() as $i => $player)
            {
                $barrel = $barrels->getNextBarrel($player->getPosition());

                if ($barrel) {
                    $cmd = sprintf("MOVE %s %s\n",
                        $barrel->getPosition()->getX(),
                        $barrel->getPosition()->getY()
                    );

                    if (in_array($cmd, $lastCommand)) {
                        $cmd = sprintf("MOVE %s %s\n",
                            abs($barrel->getPosition()->getX() - 1),
                            abs($barrel->getPosition()->gety() - 1)
                        );
                    }
                }

                if ($mine = $mines->getMineToShoot($player->getPosition())) {
                    $cmd = sprintf("FIRE %s %s\n",
                        $mine->getPosition()->getX(),
                        $mine->getPosition()->getY()
                    );
                }

                $closestEnemy = $ships->getClosestEnemy($player->getPosition());
                error_log(var_export($closestEnemy, true));
                if ($closestEnemy != null) {
                    $cannonTarget = Shooter::aimForEnemy($closestEnemy);

                    $cmd = sprintf("FIRE %s %s\n",
                        abs($cannonTarget->getX()),
                        abs($cannonTarget->getY())
                    );
                }

                // Write an action using echo(). DON'T FORGET THE TRAILING \n
                // To debug (equivalent to var_dump): error_log(var_export($var, true));

                echo ($cmd); // Any valid action, such as "WAIT" or "MOVE x y"
                $lastCommand[$i] = $cmd;
            }
        }
    }
}