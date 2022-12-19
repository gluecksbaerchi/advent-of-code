<?php

$filePointer = fopen("input_15.txt", "r");

$sensors = [];
$cave = [];
while (!feof($filePointer) && $line = trim(fgets($filePointer))) {
    $line = explode(": ", $line);
    $sensor = getCoordinates(substr($line[0], 10));
    $beacon = getCoordinates(substr($line[1], 21));

//    echo "$sensor[x] $sensor[y] $beacon[x] $beacon[y]\n";

    $sensors[] = [
        "sensor" => $sensor,
        "beacon" => $beacon
    ];

    $cave[$sensor["x"]][$sensor["y"]] = "S";
    $cave[$beacon["x"]][$beacon["y"]] = "B";
}

$lineNr = 2000000; // 2000000
$rangeToCheck = 4000000; // 4000000
for ($currLine = 0; $currLine <= $rangeToCheck; $currLine++) {
    $blockedPositions = [];
    $lineNr = $currLine;
    foreach ($sensors as $key => $sensorBeaconPair) {
        $sensor = $sensorBeaconPair["sensor"];
        $beacon = $sensorBeaconPair["beacon"];
        $distanceBeacon = abs($sensor["x"] - $beacon["x"]) + abs($sensor["y"] - $beacon["y"]);
        $distanceRow = abs($sensor["y"] - $lineNr);

        if ($distanceRow <= $distanceBeacon) {
            $distance = $distanceBeacon - $distanceRow;
//            echo "$sensor[x] $sensor[y] $beacon[x] $beacon[y]\n";
//            echo $distance . "\n";
            $blockedPositions[$key]["min"] = (($sensor["x"] - $distance) >= 0) ? $sensor["x"] - $distance : 0;
            $blockedPositions[$key]["max"] = (($sensor["x"] + $distance) <= $rangeToCheck) ? $sensor["x"] + $distance : $rangeToCheck;

//            $blockedPositions =array_unique(array_merge(
//                $blockedPositions,
//                range(
//                    (($sensor["x"] - $distance) >= 0) ? $sensor["x"] - $distance : 0,
//                    (($sensor["x"] + $distance) <= $rangeToCheck) ? $sensor["x"] + $distance : $rangeToCheck
//                )
//            ));
//            for ($x = $sensor["x"] - $distance; $x <= $sensor["x"] + $distance; $x++)
//                if (!isset($blockedPositions[$x])) {
////                    if ($x != $beacon["x"] || $beacon["y"] != $lineNr) {
//                    if ($x >= 0 && $x <= $rangeToCheck) {
////                echo "blocked $x \n";
//                        $blockedPositions[$x] = "#";
//                    }
//                }
        }
    }

    usort($blockedPositions, function ($a, $b) {
        if ($a["min"] == $b["min"]) {
            return 0;
        }
        return $a["min"] > $b["min"];
    });

    for ( $key = 0; $key < count($blockedPositions); $key++) {
        $interval = $blockedPositions[$key];
        $nextInterval = $blockedPositions[$key+1] ?? null;
//        echo "min inter " . $interval["min"] . "\n";
//        echo "max inter " . $interval["max"] . "\n";
//        if ($nextInterval !== null) {
//            echo "min next " . $nextInterval["min"] . "\n";
//            echo "max next " . $nextInterval["max"] . "\n";
//        }
        if ($nextInterval == null || $nextInterval["min"] <= $interval["max"]+1 && $nextInterval["max"]+1 >= $interval["min"]) {
            if ($nextInterval !== null) {
                $blockedPositions[$key+1]["max"] = max($interval["max"], $nextInterval["max"]);
            }
            continue;
        }
        echo "y $lineNr \n";
        echo "x " . ($interval["max"]+1) . "\n";
        $result = ($interval["max"]+1) * 4000000 + $lineNr;
        echo "result $result \n";
        return;
    }
//    echo "end \n";

//    echo $currLine . " " . count($blockedPositions) . "\n";
//    if (count($blockedPositions) <= $rangeToCheck) {
//        echo "y $lineNr \n";
//        $y = $lineNr;
//        $compare = range(0, $rangeToCheck);
//        $x = array_diff($compare, $blockedPositions);
//        $x = array_pop($x);
//        echo "x $x \n";
//        $result = $x * 4000000 + $y;
//        echo "result $result \n";
//        return;
//    }
}

//    $distance = abs($sensor["x"]-$beacon["x"]) + abs($sensor["y"]-$beacon["y"])+1;
//    // nach rechts unten
//    for ($x = $sensor["x"]; $x < $sensor["x"]+$distance; $x++) {
//        for ($y = $sensor["y"]; $y < $sensor["y"]+$distance-$x+$sensor["x"]; $y++) {
//            $cave[$x][$y] = "#";
//        }
//    }
//    // nach links unten
//    for ($x = $sensor["x"]; $x > $sensor["x"]-$distance; $x--) {
//        for ($y = $sensor["y"]; $y < $sensor["y"]+$distance+$x-$sensor["x"]; $y++) {
//            $cave[$x][$y] = "#";
//        }
//    }
//    // nach rechts oben
//    for ($x = $sensor["x"]; $x < $sensor["x"]+$distance; $x++) {
//        for ($y = $sensor["y"]; $y > $sensor["y"]-$distance+$x-$sensor["x"]; $y--) {
//            $cave[$x][$y] = "#";
//        }
//    }
//    // nach links oben
//    for ($x = $sensor["x"]; $x > $sensor["x"]-$distance; $x--) {
//        for ($y = $sensor["y"]; $y > $sensor["y"]-$distance-$x+$sensor["x"]; $y--) {
//            $cave[$x][$y] = "#";
//        }
//    }
//    $cave[$sensor["x"]][$sensor["y"]] = "S";
//    $cave[$beacon["x"]][$beacon["y"]] = "B";
//}
//
//printCave($cave);
//
//list($minX, $maxX, $minY, $maxY) = getMinMaxCoordinates($cave);
//$counter = 0;
//for ($x = $minX; $x <= $maxX; $x++) {
//    if (isset($cave[$x][$lineNr]) && $cave[$x][$lineNr] !== "B") {
//        $counter++;
//    }
//}
//echo "count $counter\n";

//echo "result: " . count($blockedPositions) . "\n";

function getCoordinates($string) {
    $values = explode(", ", $string);
    $x = str_replace("x=", "", $values[0]);
    $y = str_replace("y=", "", $values[1]);
    return ["x" => $x, "y" => $y];
}

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
            echo $cave[$x][$y] ?? ".";
        }
        echo "\n";
    }
}

####B######################

//##########S########################..
//.###########################S#######.
//..###################S#############..
//...###################SB##########...
//....#############################....
//.....###########################.....
//......#########################......
//.......#########S#######S#####.......
//........#######################......
//.......#########################.....
//......####B######################....
//.....###S#############.###########...
//......#############################..
//.......#############################.
//.......#####################S########
//......B#############################.
//.....############SB################..
//....#############################B...
//...#######S######################....
//....############################.....
//.....#############S######S######.....
//......#########################......
//.......#######..#############B.......