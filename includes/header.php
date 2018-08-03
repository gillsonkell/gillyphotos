<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>GillyPhotos | <?= $pageTitle ?></title>
		<link rel="stylesheet" href="/stylesheet.css">
	</head>
	<body>
		<header id="main-header">
			<h1>
				<a href="/">GillyPhotos</a>
			</h1>
			<nav>
				<ul>
					<li<?= ($requestedPage === 'gallery' ? ' class="currently-visited"' : '') ?>>
						<a href="/">Gallery</a>
					</li>

					<? if ($user) { ?>
						<li<?= ($requestedPage === 'user/dashboard' ? ' class="currently-visited"' : '') ?>>
							<a href="/user/dashboard">Dashboard</a>
						</li>
						<li>
							<a href="/logout">Logout</a>
						</li>
					<? } else { ?>
						<li<?= ($requestedPage === 'login' ? ' class="currently-visited"' : '') ?>>
							<a href="/login">Login</a>
						</li>
						<li<?= ($requestedPage === 'sign-up' ? ' class="currently-visited"' : '') ?>>
							<a href="/sign-up">Sign Up</a>
						</li>
					<? } ?>
				</ul>
			</nav>
		</header>
		<section id="page-content">