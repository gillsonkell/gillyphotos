<h1>Login</h1>
<form action="/login" method="POST">
	<? if ($error) { ?>
		<p class="error-message"><?= $error ?></p>
	<? } ?>

	<div class="field">
		<label for="email">Email</label>
		<input type="email" id="email" name="email" value="<?= @$_POST['email'] ?>" required>
	</div>

	<div class="field">
		<a href="/forgotten-password" class="aside">Forgot your password?</a>
		<label for="password">Password</label>
		<input type="password" id="password" name="password" required>
	</div>

	<div class="field">
		<input type="submit" value="Login">
	</div>
</form>