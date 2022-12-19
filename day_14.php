<?php

$filePointer = fopen("input_14.txt", "r");

$cave = [];
$sandStartX = 500;
$sandStartY = 0;
$sand = [];
while (!feof($filePointer) && $line = trim(fgets($filePointer))) {
    $rocks = explode(" -> ", $line);
    foreach ($rocks as $key => $currentRock) {
        $nextRock = $rocks[$key+1] ?? null;
        if ($nextRock == null) {
            continue;
        }
        list($currentRockX, $currentRockY) = explode(",", $currentRock);
        list($nextRockX, $nextRockY) = explode(",", $nextRock);

        if ($currentRockX === $nextRockX) {
            for ($i = min($currentRockY, $nextRockY); $i <= max($currentRockY, $nextRockY); $i++) {
                $cave[$currentRockX][$i] = "#";
            }
        }

        if ($currentRockY === $nextRockY) {
            for ($i = min($currentRockX, $nextRockX); $i <= max($currentRockX, $nextRockX); $i++) {
                $cave[$i][$currentRockY] = "#";
            }
        }
    }
}

list($minX, $maxX, $minY, $maxY) = getMinMaxCoordinates($cave);

// only for part 2
for ($i = 0; $i <= $sandStartX*2; $i++) {
    $cave[$i][$maxY+2] = "#";
}
// only for part 2 end

$currentSandX = $sandStartX;
$currentSandY = $sandStartY+1;
$sandCount = 0;
do {
    if (!isset($cave[$currentSandX][$currentSandY+1])) {
        $currentSandY = $currentSandY+1;
        continue;
    }
    if (!isset($cave[$currentSandX-1][$currentSandY+1])) {
        $currentSandX = $currentSandX-1;
        $currentSandY = $currentSandY+1;
        continue;
    }
    if (!isset($cave[$currentSandX+1][$currentSandY+1])) {
        $currentSandX = $currentSandX+1;
        $currentSandY = $currentSandY+1;
        continue;
    }
    $cave[$currentSandX][$currentSandY] = "o";
    $sandCount++;
    if ($currentSandX = $sandStartX && $currentSandY == $sandStartY) {
        break;
    }
    //printCave($cave);
    $currentSandX = $sandStartX;
    $currentSandY = $sandStartY;
} while ($currentSandY <= $maxY+3);

printCave($cave);
echo "sand $sandCount \n";

function getMinMaxCoordinates($cave) {
    $xValues = array_keys($cave);
    sort($xValues);
    $minX = $xValues[0];
    $maxX = $xValues[count($xValues)-1];

    $minY = 0;
    $maxY = 0;
    foreach ($cave as $value) {
        $y = array_key_first($value);
        if ($y > $maxY) {
            $maxY = $y;
        }
    }

    return [$minX, $maxX, $minY, $maxY];
}

function printCave($cave) {
    list($minX, $maxX, $minY, $maxY) = getMinMaxCoordinates($cave);

    echo "$minX $maxX $minY $maxY \n";

    for ($y = $minY; $y <= $maxY; $y++)  {
        for ($x = $minX; $x <= $maxX; $x++)  {
            if ($x == 500 && $y == 0) {
                echo "+";
                continue;
            }
            echo $cave[$x][$y] ?? ".";
        }
        echo "\n";
    }
}