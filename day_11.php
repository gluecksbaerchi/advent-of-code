<?php

$filePointer = fopen("input_11.txt", "r");

$monkeys = [];
while (!feof($filePointer) && $line = trim(fgets($filePointer))) {
    $monkeyId = substr(substr($line, 7), -2, 1);
    $startingItems = explode(", ", substr(trim(fgets($filePointer)), 16));
    $operation = str_replace("old", '$old', str_replace("new", '$new', substr(trim(fgets($filePointer)), 11))) . ";";
    $test = substr(trim(fgets($filePointer)), 19);
    $ifTrue = substr(trim(fgets($filePointer)), 25);
    $ifFalse = substr(trim(fgets($filePointer)), 26);
    fgets($filePointer); // new line

    $monkeys[$monkeyId] = new Monkey(
        $monkeyId,
        $startingItems,
        $operation,
        $test,
        $ifTrue,
        $ifFalse
    );
}

$rounds = 10000;

$testArray = [];
foreach ($monkeys as $monkey) {
    $testArray[] = $monkey->testNumber;
}
$superMod = array_product($testArray);

for ($i = 0; $i < $rounds; $i++) {
//    foreach ($monkeys as $monkey) {
//        $monkey->print();
//    }

    /** @var Monkey $monkey */
    foreach ($monkeys as $monkey) {
        foreach ($monkey->items as $key => $item) {
            $monkey->inspectionCount++;
            $old = $item;
            $new = $old;
            eval($monkey->operation);
            $worryLevel = $new % $superMod;
//            $worryLevel = floor($new / 3);
            if ($worryLevel % $monkey->testNumber === 0) {
                $monkeys[$monkey->testTrueMonkey]->items[] = $worryLevel;
            } else {
                $monkeys[$monkey->testFalseMonkey]->items[] = $worryLevel;
            }
            unset($monkey->items[$key]);
        }
    }
}

usort($monkeys, function ($monkey1, $monkey2) {
    if ($monkey1->inspectionCount === $monkey2->inspectionCount) {
        return 0;
    }
    return $monkey1->inspectionCount < $monkey2->inspectionCount ? 1 : -1;
});

foreach ($monkeys as $monkey) {
    $monkey->print();
}

echo "result: " . $monkeys[0]->inspectionCount * $monkeys[1]->inspectionCount . "\n";

class Monkey {
    public $id;
    public $items;
    public $operation;
    public $testNumber;
    public $testTrueMonkey;
    public $testFalseMonkey;
    public $inspectionCount = 0;

    /**
     * @param $id
     * @param $items
     * @param $operation
     * @param $testNumber
     * @param $testTrueMonkey
     * @param $testFalseMonkey
     */
    public function __construct($id, $items, $operation, $testNumber, $testTrueMonkey, $testFalseMonkey)
    {
        $this->id = $id;
        $this->items = $items;
        $this->operation = $operation;
        $this->testNumber = $testNumber;
        $this->testTrueMonkey = $testTrueMonkey;
        $this->testFalseMonkey = $testFalseMonkey;
    }

    public function print()
    {
        echo "Monkey $this->id:\n";
        echo "  Starting items: " . implode(", ", $this->items) . "\n";
        echo "  Operation: $this->operation\n";
        echo "  Test: divisible by $this->testNumber\n";
        echo "    If true: throw to monkey $this->testTrueMonkey\n";
        echo "    If false: throw to monkey $this->testFalseMonkey\n";
        echo "  Inspections: $this->inspectionCount\n";
        echo "\n";
    }
}