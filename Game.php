<?php

namespace Molab\Carribean;

/**
 * @author Moritz Wachter <moritzwachter@yahoo.de>
 */
class Game
{
    public static function execute()
    {
        $barrels = new BarrelContainer();
        $player = new Ship();

        // game loop
        while (TRUE)
        {
            fscanf(STDIN, "%d",
                $myShipCount // the number of remaining ships
            );
            fscanf(STDIN, "%d",
                $entityCount // the number of entities (e.g. ships, mines or cannonballs)
            );
            for ($i = 0; $i < $entityCount; $i++)
            {
                fscanf(STDIN, "%d %s %d %d %d %d %d %d",
                    $entityId,
                    $entityType,
                    $x,
                    $y,
                    $arg1,
                    $arg2,
                    $arg3,
                    $arg4
                );

                if ($entityType == TypeInterface::BARREL) {
                    if ($player->getPosition()->equals($x, $y)) {
                        $barrels->removeBarrel($x, $y);
                        error_log("removing barrel");
                    } else {
                        $barrels->addBarrel($x, $y, $arg1);
                    }
                } else if ($entityType == TypeInterface::SHIP && $arg4 == 1) {
                    $player->setPosition($x, $y);
                    $player->setDirection($arg1);
                }
            }
            for ($i = 0; $i < $myShipCount; $i++)
            {
                $barrel = $barrels->getNextBarrel($x, $y);

                $cmd = "MOVE " . $barrel->getPosition()->getX() . " " . $barrel->getPosition()->getY() . "\n";

                // Write an action using echo(). DON'T FORGET THE TRAILING \n
                // To debug (equivalent to var_dump): error_log(var_export($var, true));

                echo ($cmd); // Any valid action, such as "WAIT" or "MOVE x y"
            }
        }
    }
}