<?php

include('Barrel.php');
include('BarrelContainer.php');
include('Game.php');
include('Position.php');
include('Ship.php');
include('TypeInterface.php');

$classNames = array(
    'Molab\Carribean\Barrel',
    'Molab\Carribean\BarrelContainer',
    'Molab\Carribean\Position',
    'Molab\Carribean\Ship',
    'Molab\Carribean\Game',
    'Molab\Carribean\TypeInterface',
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





