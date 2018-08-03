<h1>Welcome back, <?= $user->name ?></h1>

<section>
	<h2>Upload a Photo</h2>
	<form action="/user/dashboard" method="POST" enctype="multipart/form-data">
		<? if ($uploadPhotoError) { ?>
			<p class="error-message"><?= $uploadPhotoError ?></p>
		<? } ?>

		<div class="field">
			<label for="upload-photo-file">File</label>
			<input type="file" name="upload-photo-file" accept="image/jpeg, image/png, image/gif" required>
		</div>

		<div class="field">
			<label for="upload-photo-title">Title</label>
			<input type="text" id="upload-photo-title" name="upload-photo-title" value="<?= @$_POST['upload-photo-title'] ?>" maxlength="48">
		</div>

		<div class="field">
			<input type="hidden" name="action" value="upload-photo">
			<input type="submit" value="Upload">
		</div>
	</form>
</section>

<section>
	<h2>Your Photos</h2>

	<ul>
		<? if ($pageNumber > 1) { ?>
			<li>
				<a href="/user/dashboard/?page=<?= $pageNumber - 1 ?>">Previous page</a>
			</li>
		<? } ?>

		<? if ($showNextPage) { ?>
			<li>
				<a href="/user/dashboard/?page=<?= $pageNumber + 1 ?>">Next page</a>
			</li>
		<? } ?>
	</ul>

	<ul class="gallery">
		<? if (empty($userPhotos)) { ?>
			<p>You have not uploaded any photos.</p>
		<? } else { ?>
			<? foreach ($userPhotos as $photo) { ?>
				<li>
					<a href="/images/original/<?= $photo->key ?>">
						<img src="/images/thumbnail/<?= $photo->key ?>" alt="<?= $photo->title ?>">
					</a>
					<span><?= htmlspecialchars($photo->title) ?></span>
					<span>
						<a href="/user/dashboard?delete-photo=<?= $photo->id ?>" class="aside">Delete</a>
					</span>
				</li>
			<? } ?>
		<? } ?>
	</ul>
</section>
