<?php

$filePointer = fopen("input_day_twelve.txt", "r");

$input = [];
while (!feof($filePointer) && $line = trim(fgets($filePointer))) $input[] = $line;

// filled out while building the graph...
$startKey = '';
$endKey = '';
$startKeys = [];
$graph = buildGraph($input);

$steps = [];
foreach (array_keys($startKeys) as $a)
    if ($path = bfs($graph, $a, $endKey))
        $steps[$a] = count($path) - 1;
asort($steps);

echo "part 1: {$steps[$startKey]}\n";
echo "part 2: {$steps[array_key_first($steps)]}\n";

function getValueFromInput($x, $y) // get value from input, look for special chars...
{
    global $input, $startKey, $endKey, $startKeys;
    $value = $input[$y][$x];
    if ($value == 'S')
    {
        if (!$startKey)
        {
            $startKey = json_encode([$x,$y]);
            $startKeys[$startKey] = 1;
        }
        return 'a';
    }
    elseif ($value == "E")
    {
        if (!$endKey) $endKey = json_encode([$x,$y]);
        return 'z';
    }
    elseif ($value == 'a') $startKeys[json_encode([$x,$y])] = 1;

    return $value;
}

function isStepAllowed($valueFrom, $valueTo): bool
{
    return ord($valueTo) - ord($valueFrom) <= 1;
}

function buildGraph(&$input): array
{
    $graph = [];
    $width = strlen($input[0]);
    for ($x = 0; $x < $width; $x++)
        for ($y = 0, $height = count($input); $y < $height; $y++)
        {
            $key = json_encode([$x, $y]);
            if (!isset($graph[$key])) $graph[$key] = [];

            $value = getValueFromInput($x, $y);
            // left
            if ($x > 0 && isStepAllowed($value, getValueFromInput($x - 1, $y)))
                $graph[$key][] = json_encode([$x - 1, $y]);
            // right
            if ($x < $width - 1 && isStepAllowed($value, getValueFromInput($x + 1, $y)))
                $graph[$key][] = json_encode([$x + 1, $y]);
            // up
            if ($y > 0 && isStepAllowed($value, getValueFromInput($x, $y - 1)))
                $graph[$key][] = json_encode([$x, $y - 1]);
            // down
            if ($y < $height - 1 && isStepAllowed($value, getValueFromInput($x, $y + 1)))
                $graph[$key][] = json_encode([$x, $y + 1]);
        }
    return $graph;
}

function bfs($graph, $start, $end = null, array &$visited = null): array
{
    $visited = [];
    $queue = new SplQueue();
    $queue->enqueue([$start]);
    $visited[$start] = true;
    while ($queue->count())
    {
        $path = $queue->dequeue();
        $node = $path[count($path)-1];
        if ($node === $end) return $path;
        foreach ($graph[$node] as $adj)
        {
            if (!isset($visited[$adj]))
            {
                $visited[$adj] = true;
                $currentPath = $path;
                $currentPath[] = $adj;
                $queue->enqueue($currentPath);
            }
        }
    }
    return [];
}
