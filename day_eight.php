<?php
// input_day_eight
$filePointer = fopen("input_day_eight.txt", "r");

$forest = [];
$index = 0;
while (!feof($filePointer) && $line = trim(fgets($filePointer)))
{
    $forest[$index] = str_split($line);
    $index++;
}

$visibleTreesCount = 4 * count($forest) - 4;
$highestTreeScore = 0;

for ($i = 1; $i < count($forest)-1; $i++) {
    for ($j = 1; $j < count($forest)-1; $j++) {
        echo "$i $j " . $forest[$i][$j] . "\n";
        $topCount = 0;
        $bottomCount = 0;
        $leftCount = 0;
        $rightCount = 0;
        $hiddenTop = false;
        $hiddenBottom = false;
        $hiddenLeft = false;
        $hiddenRight = false;
        foreach ($forest as $key => $treeLine) {
            if ($key < $i) {
                $topCount++;
            }
            if ($key > $i && !$hiddenBottom) {
                $bottomCount++;
            }
            if ($key < $i && $treeLine[$j] >= $forest[$i][$j]) {
                // versteckt von oben
                $topCount = 1;
                $hiddenTop = true;
            }
            if ($key > $i && $treeLine[$j] >= $forest[$i][$j]) {
                // versteckt von unten
                $hiddenBottom = true;
            }
            if ($key == $i) {
                $leftTrees = array_slice($treeLine, 0, $j);
                foreach (array_reverse($leftTrees) as $leftTree) {
                    $leftCount++;
                    if ($leftTree >= $forest[$i][$j]) {
                        break;
                    }
                }
                if (max($leftTrees) >= $forest[$i][$j]) {
                    // versteckt von links
                    $hiddenLeft = true;
                }
                $rightTrees = array_slice($treeLine, $j+1);
                foreach ($rightTrees as $rightTree) {
                    $rightCount++;
                    if ($rightTree >= $forest[$i][$j]) {
                        break;
                    }
                }
                if (max($rightTrees) >= $forest[$i][$j]) {
                    // versteckt von rechts
                    $hiddenRight = true;
                }
            }
        }
        echo "top $topCount bottom $bottomCount right $rightCount left $leftCount\n";
        echo "result: " . $topCount*$bottomCount*$rightCount*$leftCount . "\n";
        $highestTreeScore = max($topCount*$bottomCount*$rightCount*$leftCount, $highestTreeScore);
        if ($hiddenTop == false || $hiddenBottom == false || $hiddenRight == false || $hiddenLeft == false) {
            echo "visible tree \n";
            $visibleTreesCount++;
        }
    }
}

echo "$visibleTreesCount trees are visible\n";
echo "$highestTreeScore is the best score\n";