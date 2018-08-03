<?php

if (empty($_REQUEST['key'])) {
	header('Location: /forgotten-password');
	exit;
}

$getResetKey = $database->prepare("SELECT * FROM password_reset_keys WHERE key = ? AND created_date > NOW() - INTERVAL '1 day'");
$getResetKey->execute([$_REQUEST['key']]);
$resetKey = $getResetKey->fetch();

if (!$resetKey) {
	header('Location: /forgotten-password');
	exit;
}

if (!empty($_POST)) {
	$newPassword = password_hash(@$_POST['password'], PASSWORD_DEFAULT);
	
	if (!empty($newPassword)) {
		$updateUser = $database->prepare("UPDATE users SET password = :password WHERE id = :id");
		$updateUser->bindValue('password', $newPassword);
		$updateUser->bindValue('id', $resetKey->user_id);
		$updateUser->execute();

		$_SESSION['user_id'] = $resetKey->user_id;
		header('Location: /user/dashboard');
		exit;
	}
}
