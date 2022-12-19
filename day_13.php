<?php

$filePointer = fopen("input_13.txt", "r");

$input = [];
$pairCount = 0;
while (!feof($filePointer) && $line = fgets($filePointer)) {
    if ($line == "\r\n") {
        $pairCount++;
    } else {
        $arr = [];
        eval("\$arr = $line;");
//        $input[$pairCount][] = $arr; // for part 1
        $input[] = $arr;
    }
}

/* part one
$results = [];
$sum = 0;
foreach ($input as $key => $pair) {
    $result = compare($pair, 0);
    $results[] = $result;
    echo ($result < 1 ? "true" : "false") . " for $key \n";
    if ($result < 1) {
        $sum += $key+1;
    }
}
echo "sum $sum\n";
*/

//var_dump($input[0]);

// part two
$input[] = [[2]];
$input[] = [[6]];
usort($input, "customCompare");
//var_dump($input);
$result = (array_search([[2]], $input) + 1) * (array_search([[6]], $input) + 1);
echo "result $result\n";

function customCompare($one, $two) {
    return compare([$one, $two]);
}

// -1, 0, 1
function compare($pair) {
//    echo json_encode($pair) . "\n";

    $element1 = $pair[0]; // [1,10,[[3,1,0,7,10],[9,10,6,2,1],[3,5],2],[8,[3,0]]]
    $element2 = $pair[1]; // [4,0,[],[1,[8,2,7,8,10],9,[10,4,8,3,9]]]

    if (is_array($element1) && !is_array($element2)) {
        $element2 = [$element2];
    } elseif (is_array($element2) && !is_array($element1)) {
        $element1 = [$element1];
    }

    if (!is_array($element1)) {
        if ((int)$element1 > (int)$element2) {
            return 1;
        }
        if ((int)$element1 == (int)$element2) {
            return 0;
        }
        return -1;
    }

    while (count($element1) && count($element2))
    {
        $left = array_shift($element1);
        $right = array_shift($element2);
        if ($result = compare([$left, $right])) return $result;
    }
    return count($element1) - count($element2);
}