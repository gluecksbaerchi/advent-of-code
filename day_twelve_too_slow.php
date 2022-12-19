<?php
$filePointer = fopen("input_day_twelve.txt", "r");

$originalMap = [];
$map = [];
$alphabet = range('a', 'z');

$startX = 0;
$startY = 0;
$endX = 0;
$endY = 0;

$count = 0;
while (!feof($filePointer) && $line = trim(fgets($filePointer)))
{
    $splitLine = str_split($line);
    $originalMap[] = str_split($line);

    $numberLine = [];
    foreach ($splitLine as $key => $value) {
        if ($value === "S") {
            $numberLine[] = array_search('a', $alphabet);
            $startX = $count;
            $startY = $key;
            continue;
        }
        if ($value === "E") {
            $numberLine[] = array_search('z', $alphabet);
            $endX = $count;
            $endY = $key;
            continue;
        }
        $numberLine[] = array_search($value, $alphabet);
    }
    $map[] = $numberLine;
    $count++;
}

echo "start at ($startX, $startY) end at ($endX, $endY) \n\n";

$shortestPath = 10000000000;

//printMap($originalMap);
//echo "\n";
//printMap($map);

echo checkPath(new PathMap($map, $startX, $startY, []), $endX, $endY, $shortestPath) . "\n";

function checkPath($pathMap, $endX, $endY, $shortestPath) {
    $currentPositionX = $pathMap->currentPositionX;
    $currentPositionY = $pathMap->currentPositionY;
//        echo "($currentPositionX, $currentPositionY)\n";

    // mark position as visited
    $newMap = $pathMap->map;
    $newMap[$currentPositionX][$currentPositionY] = ".";

    if ($currentPositionX == $endX && $currentPositionY == $endY) {
        if ($shortestPath > count($pathMap->way)) {
            $shortestPath = count($pathMap->way);
        }
        echo count($pathMap->way) . "\n";
        return $shortestPath;
    }

    if (count($pathMap->way) > $shortestPath) {
        return $shortestPath;
    }

    // look around
    // up
    if (isset($pathMap->map[$currentPositionX][$currentPositionY-1]) && $pathMap->map[$currentPositionX][$currentPositionY-1] !== '.' && abs($pathMap->map[$currentPositionX][$currentPositionY-1] - $pathMap->map[$currentPositionX][$currentPositionY]) <= 1) {
        $result = checkPath(new PathMap($newMap, $currentPositionX, $currentPositionY-1, array_merge($pathMap->way, ["($currentPositionX, $currentPositionY)"])), $endX, $endY, $shortestPath);
        if ($result < $shortestPath) {
            $shortestPath = $result;
        }
    }
    // down
    if (isset($pathMap->map[$currentPositionX][$currentPositionY+1]) && $pathMap->map[$currentPositionX][$currentPositionY+1] !== '.' && abs($pathMap->map[$currentPositionX][$currentPositionY+1] - $pathMap->map[$currentPositionX][$currentPositionY]) <= 1) {
        $result = checkPath(new PathMap($newMap, $currentPositionX, $currentPositionY+1, array_merge($pathMap->way, ["($currentPositionX, $currentPositionY)"])), $endX, $endY, $shortestPath);
        if ($result < $shortestPath) {
            $shortestPath = $result;
        }
    }
    // right
    if (isset($pathMap->map[$currentPositionX+1][$currentPositionY]) && $pathMap->map[$currentPositionX+1][$currentPositionY] !== '.' && abs($pathMap->map[$currentPositionX+1][$currentPositionY] - $pathMap->map[$currentPositionX][$currentPositionY]) <= 1) {
        $result = checkPath(new PathMap($newMap, $currentPositionX+1, $currentPositionY, array_merge($pathMap->way, ["($currentPositionX, $currentPositionY)"])), $endX, $endY, $shortestPath);
        if ($result < $shortestPath) {
            $shortestPath = $result;
        }
    }
    // left
    if (isset($pathMap->map[$currentPositionX-1][$currentPositionY]) && $pathMap->map[$currentPositionX-1][$currentPositionY] !== '.' && abs($pathMap->map[$currentPositionX-1][$currentPositionY] - $pathMap->map[$currentPositionX][$currentPositionY]) <= 1) {
        $result = checkPath(new PathMap($newMap, $currentPositionX-1, $currentPositionY, array_merge($pathMap->way, ["($currentPositionX, $currentPositionY)"])), $endX, $endY, $shortestPath);
        if ($result < $shortestPath) {
            $shortestPath = $result;
        }
    }
    return $shortestPath;
}

function printMap($map) {
    foreach ($map as $line) {
        foreach ($line as $char) {
            echo $char . " ";
        }
        echo "\n";
    }
}

class PathMap {
    public $map = [];
    public $currentPositionX = 0;
    public $currentPositionY = 0;
    public $way = [];

    /**
     * @param array $map
     * @param int $currentPositionX
     * @param int $currentPositionY
     * @param array $way
     */
    public function __construct(array $map, int $currentPositionX, int $currentPositionY, array $way)
    {
        $this->map = $map;
        $this->currentPositionX = $currentPositionX;
        $this->currentPositionY = $currentPositionY;
        $this->way = $way;
    }

    public function print()
    {
        echo "path ";
        echo implode(", ", $this->way);
        echo "\n";
    }
}