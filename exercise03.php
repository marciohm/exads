<?php

class ExadsTest {

	public function __construct() {
		$this->PDO = new \PDO("mysql:host=localhost;port=3306;Dbname=exads", 'dbuser', 'dbpass');
		$this->PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}

	public function getAll() {
		$sql = "SELECT * FROM exads_test";
		$sth = $this->PDO->prepare($sql);
		$sth->execute();
		return $sth->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function get($queryString) {
		$sql = "SELECT * FROM exads_test where (name like :queryString or job_title like :queryString);";
		$sth = $this->PDO->prepare($sql);
		$sth->bindValue(':queryString', '%'.$queryString.'%');
		$sth->execute();
		return $sth->fetch(\PDO::FETCH_ASSOC);
	}

}

$exads_test = new ExadsTest();
$tests      = $exads_test->getAll();

foreach ($tests as $test) {
	echo $test->name;
	echo $test->age;
	echo $test->job_title;
}