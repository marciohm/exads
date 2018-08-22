<?php

for ($i = 1; $i <= 100; $i++) {
	switch ($i) {
		case ($i%5) == 0 && ($i%3) == 0:
			echo "FizzBuzz ";
			break;

		case ($i%5) == 0:
			echo "Buzz ";
			break;

		case ($i%3) == 0:
			echo "Fizz ";
			break;

		default:
			echo $i." ";
			break;
	}

}