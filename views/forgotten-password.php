<h1>Reset Your Password</h1>

<? if (empty($_POST)) { ?>
	<form action="/forgotten-password" method="POST">
		<div class="field">
			<label for="email">Email</label>
			<input type="email" id="email" name="email" required>
		</div>

		<div class="field">
			<input type="submit" value="Reset your password">
		</div>
	</form>
<? } else { ?>
	<p>If there was a user found under that address, we have sent it an email with further instructions.</p>
<? } ?>

