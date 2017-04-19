<?php 

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
    public function add($x, $y, $amount, $entityId) {
        $this->container[$entityId] = new Barrel($x, $y, $amount);
    }

    /**
     * @param Position $position
     * @return Barrel
     */
    public function getNextBarrel(Position $position) {
        return $this->getClosestBarrel($position);
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

    /**
     *
     * @param Position $fromPosition
     * @return Barrel
     */
    public function getClosestBarrel(Position $fromPosition)
    {
        $closestKey = null;
        $minimalDiff = 1000;

        foreach ($this->container as $i => $barrel) {
            $diff = $barrel->getPosition()->diff($fromPosition);

            if ($diff < $minimalDiff) {
                $closestKey = $i;
                $minimalDiff = $diff;
            }
        }

        if (array_key_exists($closestKey, $this->container)) {
            return $this->container[$closestKey];
        }

        return null;
    }
}

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

    /**
     * @param Position $position
     * @return number
     */
    public function diff(Position $position)
    {
        $diffX = abs($position->getX() - $this->x);
        $diffY = abs($position->getY() - $this->y);

        return $diffX + $diffY;
    }
}

class Ship
{
    /** Position $position */
    protected $position;

    /** @var  int $direction */
    protected $direction;

    /** @var  int $speed */
    protected $speed;

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

    /**
     * @param $arg2
     */
    public function setSpeed($arg2)
    {
        $this->speed = $arg2;
    }

    /**
     * @return int
     */
    public function getSpeed()
    {
        return $this->speed;
    }
}

class Mine extends Cannonball
{
}

class Enemy extends Ship
{
}

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

class MineContainer
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
    public function add($x, $y, $entityId) {
        $this->container[$entityId] = new Mine($x, $y);
    }

    /**
     * @param $x
     * @param $y
     */
    public function remove($x, $y) {
        foreach($this->container as $i => $mine) {
            if ($mine->getPosition()->equals($x, $y)) {
                unset($this->container[$i]);
            }
        }
    }

    /**
     * @param Position $fromPosition
     * @return Barrel|null
     */
    public function getMineToShoot(Position $fromPosition)
    {
        $closestKey = null;
        $minimalDiff = 4;

        foreach ($this->container as $i => $barrel) {
            $diff = $barrel->getPosition()->diff($fromPosition);

            if ($diff < $minimalDiff) {
                $closestKey = $i;
                $minimalDiff = $diff;
            }
        }

        if (array_key_exists($closestKey, $this->container)) {
            return $this->container[$closestKey];
        }

        return null;
    }
}

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

final class Type {
    const BARREL = 'BARREL';
    const SHIP = 'SHIP';
    const CANNON = 'CANNONBALL';
    const MINE = 'MINE';
}

final class Directions {
    const E = 0;
    const NE = 1;
    const NW = 2;
    const W = 3;
    const SW = 4;
    const SE = 5;
}

Game::execute();
