<?php
$filePointer = fopen("input_day_nine.txt", "r");

$start = 10;
//$ropeSize = 1;
$ropeSize = 9;
$rope = [];
for($n = 0; $n <= $ropeSize; $n++) {
    $rope[] = new Position($start, $start);
}

$field = array_fill(0, $start*2, array_fill(0, $start*2, "."));

$visitedFields = ["$start $start"];
while (!feof($filePointer) && $line = trim(fgets($filePointer)))
{
    list($direction, $steps) = explode(" ", $line);
    echo "$direction $steps\n";

    for ($i = 0; $i < $steps; $i++) {
        $head = $rope[0];
        switch ($direction) {
            case "L":
                $head->x--;
                break;
            case "R":
                $head->x++;
                break;
            case "U":
                $head->y++;
                break;
            case "D":
                $head->y--;
        }
        echo "step $i\n";
        for ($j = 0; $j < $ropeSize; $j++) {
            $head = $rope[$j];
            $tail = $rope[$j+1];

            if ($head->y == $tail->y && abs($head->x - $tail->x) > 1) {
                $tail->x += ($head->x > $tail->x) ? 1 : -1;
            } elseif ($head->x == $tail->x && abs($head->y - $tail->y) > 1) {
                $tail->y += ($head->y > $tail->y) ? 1 : -1;
            } elseif (abs($head->x - $tail->x) + abs($head->y - $tail->y) > 2) {
                $tail->x += ($head->x > $tail->x) ? 1 : -1;
                $tail->y += ($head->y > $tail->y) ? 1 : -1;
            }
        }
        if (!in_array("{$tail->x} {$tail->y}", $visitedFields)) {
            $visitedFields[] = "{$tail->x} {$tail->y}";
        }
//        printField($field, $rope);
    }
}

echo "result " . count($visitedFields) . "\n";

function printField($field, $rope) {
    foreach ($rope as $index => $ropeSegment) {
        $field[$ropeSegment->y][$ropeSegment->x] = $index;
    }
    foreach ($field as $value) {
        echo implode(" ", $value) . "\n";
    }
    echo "\n";
}

class Position {
    public int $x;
    public int $y;

    /**
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

}