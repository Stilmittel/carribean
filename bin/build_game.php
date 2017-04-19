<?php

include('BarrelContainer.php');
include('CannonContainer.php');
include('MineContainer.php');
include('ShipContainer.php');
include('Game.php');
include('Type.php');
include('Shooter.php');
include('Directions.php');

include('Models/Barrel.php');
include('Models/Position.php');
include('Models/Cannonball.php');
include('Models/Ship.php');
include('Models/Mine.php');
include('Models/Enemy.php');

$classNames = array(
    'Molab\Carribean\BarrelContainer',
    'Molab\Carribean\Models\Barrel',
    'Molab\Carribean\Models\Position',
    'Molab\Carribean\Models\Ship',
    'Molab\Carribean\Models\Mine',
    'Molab\Carribean\Models\Enemy',
    'Molab\Carribean\Models\Cannonball',


    'Molab\Carribean\CannonContainer',
    'Molab\Carribean\MineContainer',
    'Molab\Carribean\ShipContainer',

    'Molab\Carribean\Game',
    'Molab\Carribean\Shooter',
    'Molab\Carribean\Type',
    'Molab\Carribean\Directions',
);

$finalContent = "";
$finalContent .= "<?php \n\n";

foreach($classNames as $className) {
    $reflection = new ReflectionClass($className);
    $startLine = $reflection->getStartLine();

    $content = file_get_contents($reflection->getFileName());

    $lines = explode("\n", $content);

    for ($i=0; $i < $reflection->getStartLine() - 1; $i++) {
        unset($lines[$i]);
    }

    $fileContent = implode("\n", $lines);

    $finalContent .= $fileContent . "\n\n";
}

$finalContent .= "Game::execute();\n";


$file = fopen("dist/game.php", "w");
fwrite($file, $finalContent);
fclose($file);

echo "Game built. \n";
