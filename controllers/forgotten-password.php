<?php

if (!empty($_POST)) {
	$userEmail = trim(@$_POST['email']);

	if (!empty($userEmail)) {
		$getUser = $database->prepare("SELECT * FROM users WHERE LOWER(email) = ?");
		$getUser->execute([$userEmail]);
		$user = $getUser->fetch();

		if ($user) {
			$newKey = bin2hex(random_bytes(8));
			
			$addKey = $database->prepare("INSERT INTO password_reset_keys (user_id, key) VALUES (:user_id, :key)");
			$addKey->bindValue('user_id', $user->id);
			$addKey->bindValue('key', $newKey);
			$addKey->execute();

			$resetLink = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/password-reset?key=' . $newKey;
			sendEmail($user->email, 'Password Reset', 'Please follow <a href="' . $resetLink . '">this link</a> to reset your password.');
		}
	}
}
