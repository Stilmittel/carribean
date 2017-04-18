<?php 

class Barrel
{
    /** @var Position  */
    protected $position;

    /** @var  int $amount */
    protected $amount;

    /**
     * @param $x
     * @param $y
     * @param $amount
     */
    public function __construct($x, $y, $amount)
    {
        $this->position = new Position($x, $y);
        $this->amount = $amount;
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s|%s|%s", $this->position->getX(), $this->position->getY(), $this->amount);
    }
}

class BarrelContainer
{
    /** @var Barrel[] */
    protected $container;

    public function __construct() {
        $this->container = [];
    }

    /**
     * @param $x
     * @param $y
     * @param $amount
     */
    public function addBarrel($x, $y, $amount) {
        $this->container[] = new Barrel($x, $y, $amount);
    }

    /**
     * @param $x
     * @param $y
     * @return Barrel
     */
    public function getNextBarrel($x, $y) {
        return $this->getClosestBarrel($x, $y);
    }

    /**
     * @param $x
     * @param $y
     */
    public function removeBarrel($x, $y) {
        foreach($this->container as $i => $barrel) {
            if ($barrel->getPosition()->equals($x, $y)) {
                unset($this->container[$i]);
            }
        }
    }

    /**
     * @param $x
     * @param $y
     *
     * @return Barrel
     */
    public function getClosestBarrel($x, $y)
    {
        $closestKey = null;
        $minimalDiff = 1000;

        foreach ($this->container as $i => $barrel) {
            $diffX = abs($barrel->getPosition()->getX() - $x);
            $diffY = abs($barrel->getPosition()->getY() - $y);

            $diff = $diffX + $diffY;

            if ($diff < $minimalDiff) {
                $closestKey = $i;
            }
        }

        return $this->container[$i];
    }
}

class Position {

    /** @var  int $x */
    protected $x;

    /** @var  int $y */
    protected $y;

    /**
     * @param $x
     * @param $y
     */
    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param $x
     * @param $y
     * @return bool
     */
    public function equals($x, $y) {
        if (true) {
            error_log(
                sprintf("%s|%s ? %s|%s",
                    $x,
                    $y,
                    $this->x,
                    $this->y
                )
            );
        }
        return $this->x == $x && $this->y == $y;
    }

    /**
     * @return int
     */
    public function getX() {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY() {
        return $this->y;
    }
}

class Ship
{
    /** Position $position */
    protected $position;

    /** @var  int $direction */
    protected $direction;

    /**
     * @param $x
     * @param $y
     */
    public function setPosition($x, $y) {
        $this->position = new Position($x, $y);
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $dir
     */
    public function setDirection($dir)
    {
        $this->direction = $dir;
    }

    /**
     * @return int
     */
    public function getDirection()
    {
        return $this->direction;
    }
}

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

interface TypeInterface {
    const BARREL = 'BARREL';
    const SHIP = 'SHIP';
    const CANNON = 'CANNONBALL';
    const MINE = 'MINE';
}

Game::execute();
