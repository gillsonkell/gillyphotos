<?php

$pageNumber = @$_GET['page'];
if (!$pageNumber) {
	$pageNumber = 1;
}

$photosPerPage = 6;
$photos = $database->query("
	SELECT photos.*, users.name AS user_name
	FROM photos
	JOIN users ON users.id = photos.user_id
	ORDER BY uploaded_date DESC
	LIMIT " . ($photosPerPage + 1) . "
	OFFSET " . (($pageNumber - 1) * $photosPerPage) . "
")->fetchAll();

$showNextPage = false;
if (count($photos) > $photosPerPage) {
	$showNextPage = true;
	array_pop($photos);
}
