<?php

require 'config.php';

session_start();
$user = null;
if (!empty($_SESSION['user_id'])) {
	$getUser = $database->prepare("SELECT * FROM users WHERE id = ?");
	$getUser->execute([$_SESSION['user_id']]);
	$user = $getUser->fetch();
}

$requestedPage = trim(strtok(strtolower($_SERVER['REQUEST_URI']), '?'), '/');
if (!$requestedPage) {
	$requestedPage = 'gallery';
}

if (substr($requestedPage, 0, 5) === 'user/') {
	if (!$user) {
		header('Location: /login');
		exit;
	}
}

$controller = 'controllers/' . $requestedPage . '.php';
$controllerExists = file_exists($controller);
$view = 'views/' . $requestedPage . '.php';
$viewExists = file_exists($view);

if (!$controllerExists && !$viewExists) {
	$view = 'views/404-error.php';
	$viewExists = true;
}

$pageTitle = basename($view, '.php');
$pageTitle = str_replace('-', ' ', $pageTitle);
$pageTitle = ucwords($pageTitle);

if ($controllerExists) {
	require $controller;
}

if ($viewExists) {
	require 'includes/header.php';
	require $view;
	require 'includes/footer.php';
}
