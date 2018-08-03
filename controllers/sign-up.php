<?php

$error = null;

if (!empty($_POST)) {
	$userEmail = trim(@$_POST['email']);
	$userPassword = password_hash(@$_POST['password'], PASSWORD_DEFAULT);
	$userName = trim(@$_POST['name']);
	
	if (empty($userEmail) || empty($userPassword) || empty($userName)) {
		$error = 'Form is missing one or more required fields.';
	}
	
	if (!$error && strlen($userName) > 48) {
		$error = 'The provided name is too long.';
	}

	if (!$error) {
		$getExistingUser = $database->prepare("SELECT * FROM users WHERE LOWER(email) = :email OR LOWER(name) = :name");
		$getExistingUser->bindValue('email', strtolower($userEmail));
		$getExistingUser->bindValue('name', strtolower($userName));
		$getExistingUser->execute();
		$existingUser = $getExistingUser->fetch();
		
		if ($existingUser) {
			if (strtolower($existingUser->email) === strtolower($userEmail)) {
				$error = 'There is already a user under the provided email.';
			} else {
				$error = 'There is already a user under the provided name.';
			}
		}
	}

	if (!$error) {
		$addUser = $database->prepare("INSERT INTO users (email, password, name) VALUES (:email, :password, :name) RETURNING id");
		$addUser->bindValue('email', $userEmail);
		$addUser->bindValue('password', $userPassword);
		$addUser->bindValue('name', $userName);
		$addUser->execute();
		$newUserId = $addUser->fetchColumn();

		$_SESSION['user_id'] = $newUserId;
		header('Location: /user/dashboard');
		exit;
	}
}
