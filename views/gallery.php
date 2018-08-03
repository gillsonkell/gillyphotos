<h1>Gallery</h1>

<ul>
	<? if ($pageNumber > 1) { ?>
		<li>
			<a href="/?page=<?= $pageNumber - 1 ?>">Previous page</a>
		</li>
	<? } ?>

	<? if ($showNextPage) { ?>
		<li>
			<a href="/?page=<?= $pageNumber + 1 ?>">Next page</a>
		</li>
	<? } ?>
</ul>

<ul class="gallery">
	<? if (empty($photos)) { ?>
		<p>No photos have been uploaded.</p>
	<? } else { ?>
		<? foreach ($photos as $photo) { ?>
			<li>
				<a href="/images/original/<?= $photo->key ?>">
					<img src="/images/thumbnail/<?= $photo->key ?>" alt="<?= $photo->title ?>">
				</a>
				<span><?= htmlspecialchars($photo->title) ?></span>
				<span class="aside"><?= htmlspecialchars($photo->user_name) ?></span>
			</li>
		<? } ?>
	<? } ?>
</ul>
