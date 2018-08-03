<?php

$error = null;

if (!empty($_POST)) {
	$userEmail = trim(@$_POST['email']);
	$userPassword = @$_POST['password'];
	
	if (empty($userEmail) || empty($userPassword)) {
		$error = 'Form is missing one or more required fields.';
	}

	if (!$error) {
		$getUser = $database->prepare("SELECT * FROM users WHERE LOWER(email) = ?");
		$getUser->execute([$userEmail]);
		$user = $getUser->fetch();

		if (!$user || !password_verify($userPassword, $user->password)) {
			$error = 'Incorrect password or non-existent account.';
		}
	}

	if (!$error) {
		$_SESSION['user_id'] = $user->id;
		header('Location: /user/dashboard');
		exit;
	}
}
