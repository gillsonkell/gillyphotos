<h1>Reset your password</h1>
<form action="/password-reset" method="POST">
	<div class="field">
		<label for="password">New password</label>
		<input type="password" id="password" name="password" required>
	</div>

	<div class="field">
		<input type="hidden" name="key" value="<?= @$_GET['key'] ?>">
		<input type="submit" value="Reset your password">
	</div>
</form>
