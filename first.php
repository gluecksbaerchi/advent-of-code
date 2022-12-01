<?php

$lines = file('first_input.txt');

$result =  0;
$currentCalories = 0;
$elveCalories = [];
foreach($lines as $line) {
	if ($line == "\r\n"){
		echo "empty , currentCalories $currentCalories\n";
		//if ($currentCalories > $result) $result = $currentCalories;
		$elveCalories[] = (int)$currentCalories;
		$currentCalories = 0;
	}
	$currentCalories += (int)$line;
	echo "$line $currentCalories\n";
}

arsort($elveCalories);
$elveCalories = array_slice($elveCalories, 0, 3);
foreach($elveCalories as $ec) {
	echo $ec . "\n";
	$result += $ec;
}
echo "result $result";