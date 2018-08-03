<h1>Sign Up</h1>
<form action="/sign-up" method="POST">
	<? if ($error) { ?>
		<p class="error-message"><?= $error ?></p>
	<? } ?>

	<div class="field">
		<label for="email">Email</label>
		<input type="email" id="email" name="email" value="<?= @$_POST['email'] ?>" required>
	</div>

	<div class="field">
		<label for="password">Password</label>
		<input type="password" id="password" name="password" value="<?= @$_POST['password'] ?>" required>
	</div>

	<div class="field">
		<label for="name">Name</label>
		<input type="text" id="name" name="name" maxlength="48" value="<?= @$_POST['name'] ?>" required>
	</div>

	<div class="field">
		<input type="submit" value="Sign up">
	</div>
</form>
