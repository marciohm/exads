<?php
echo "<pre>";

$array = [];
for ($i = 0; $i < 500; $i++) {
	array_push($array, rand(1, 500));
}

$removedIndex = rand(0, 499);

unset($array[$removedIndex]);

echo "Removed element: $removedIndex <br/>";
var_dump($array);
echo "</pre>";