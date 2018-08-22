<?php

class Design {

	public function __construct() {
		$this->PDO = new \PDO("mysql:host=localhost;port=3306;Dbname=exads", 'dbuser', 'dbpass');
		$this->PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}

	public function getAll() {
		$sql = "SELECT * FROM designers";
		$sth = $this->PDO->prepare($sql);
		$sth->execute();
		return $sth->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getNumberOfUsers() {
		$sql = "SELECT count(*) as numberOfUsers from users";
		$sth = $this->PDO->prepare($sql);
		$sth->execute();
		return $sth->fetch(\PDO::FETCH_ASSOC);
	}

	public function getUsersList() {
		$sql = "SELECT users.id, users.email
		FROM users
		WHERE NOT EXISTS(select id from ab_test_designers where ab_test_designers.user_id = users.id)";
		$sth = $this->PDO->prepare($sql);
		$sth->execute();
		return $sth->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function sendMailABTeste($userId, $userEmail, $designId, $designName) {
		sendEmail($userEmail, $designName);

		$sql = "insert into ab_test_designers (user_id, design_id) values (:userId, :designId); ";
		$sth = $this->PDO->prepare($sql);
		$sth->bindValue(':userId', $userId);
		$sth->bindValue(':designId', $designId);
		return $sth->execute();
	}

}

$designModel = new Design();

//Get designers list
$designers = $designModel->getAll();

//Get number of users on the database
$numberOfUsers = $designModel->getNumberOfUsers()->numberOfUsers;

//Iterate in designers list
foreach ($designers as $design) {

	//Get list of users that don't receive thet AB Test
	$users = $designModel->getUsersList();

	//Calc the number of users to receive tha AB Test in acording to design split percent
	$numberOfTests = ceil(($design->split_percent*$numberOfUsers)/100);

	//Iterate in users list
	for ($i = 0; $i < $numberOfTests; $i++) {

		//Send email for user and set it as "sent"
		$designModel->sendMailABTeste($users[0]->id, $users[0]->email, $design->id, $design->name);
	}
}