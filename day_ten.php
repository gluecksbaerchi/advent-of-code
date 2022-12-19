<?php
$filePointer = fopen("input_day_ten.txt", "r");

$x = 1;
$cycle = 1;
$cycles = [20, 60, 100, 140, 180, 220];
$sum = 0;

$output = array_fill(1, 240, ".");
$outputOffset = 0;

$position = [1,2,3];

while (!feof($filePointer) && $line = trim(fgets($filePointer)))
{
    if (in_array($cycle, $position)) {
        $output[$cycle] = "#";
    }

    $lineSegments = explode(" ", $line);
    $operation = $lineSegments[0];
    $value = $lineSegments[1] ?? null;

    echo "op $operation val $value x $x cycle $cycle pos $position[0] $position[1] $position[2]\n";

    // todo
    if (in_array($cycle, $cycles)) {
        $sum += $cycle*$x;
    }

    $cycle++;
    if ($cycle%40 == 0) {
        $outputOffset += 40;
    }
    if ($operation == "noop") {
        continue;
    }
    if (in_array($cycle, $position)) {
        $output[$cycle] = "#";
    }
    $cycle++;
    if ($cycle%40 == 0) {
        $outputOffset += 40;
    }
    $x += $value;
    $position = [$x+$outputOffset, $x+$outputOffset+1, $x+$outputOffset+2];
}

printField($output);

echo "result is $sum \n";


function printField($field) {
//    foreach ($rope as $index => $ropeSegment) {
//        $field[$ropeSegment->y][$ropeSegment->x] = $index;
//    }
    foreach ($field as $key => $value) {
        echo $value;
        if ($key % 40 == 0) {
            echo "\n";
        }
    }
    echo "\n";
}