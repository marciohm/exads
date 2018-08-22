<?php

class ExadsTest {

	public static function getNextValidDrawDate($date = null) {
		if (empty($date)) {
			$date = new DateTime();
		}

		if ($date->format('D') == 'Wed' || $date->format('D') == 'Sat') {
			return $date->format('Y-m-d');
		} else {
			$date->add(new DateInterval('P1D'));
			return self::getNextValidDrawDate($date);
		}
	}

}

echo ExadsTest::getNextValidDrawDate();
