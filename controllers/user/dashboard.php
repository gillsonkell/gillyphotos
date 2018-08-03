<?php

$uploadPhotoError = null;

if (!empty($_GET['delete-photo'])) {
	$getPhotoToDelete = $database->prepare("SELECT * FROM photos WHERE user_id = :user_id AND id = :id");
	$getPhotoToDelete->bindValue('user_id', $user->id);
	$getPhotoToDelete->bindValue('id', $_GET['delete-photo']);
	$getPhotoToDelete->execute();
	$photoToDelete = $getPhotoToDelete->fetch();

	if ($photoToDelete) {
		$database->prepare("DELETE FROM photos WHERE id = :id")->execute([$photoToDelete->id]);
		unlink('public/images/original/' . $photoToDelete->key);
		unlink('public/images/thumbnail/' . $photoToDelete->key);
	}

	header('Location: /user/dashboard');
	exit;
}

if (!empty($_POST)) {
	$action = @$_POST['action'];

	if ($action === 'upload-photo') {
		$photoTitle = @$_POST['upload-photo-title'];
		if (strlen($photoTitle) > 48) {
			$uploadPhotoError = 'The provided photo title is too long.';
		}

		if (!$uploadPhotoError && empty($_FILES['upload-photo-file'])) {
			$uploadPhotoError = 'No file selected.';
		}

		if (!$uploadPhotoError && !empty($_FILES['upload-photo-file']['error'])) {
			$uploadPhotoError = 'There was a problem uploading that file.';
		}

		if (!$uploadPhotoError) {
			$mime = mime_content_type($_FILES['upload-photo-file']['tmp_name']);
			if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) {
				$uploadPhotoError = 'Invalid file. Supported types are JPEG, PNG, and GIF.';
			}
		}

		if (!$uploadPhotoError) {
			$mimeExtensions = [
				'image/jpeg' => '.jpg',
				'image/png' => '.png',
				'image/gif' => '.gif'
			];
			$photoKey = bin2hex(random_bytes(8)) . $mimeExtensions[$mime];
			move_uploaded_file($_FILES['upload-photo-file']['tmp_name'], 'public/images/original/' . $photoKey);

			if ($mime === 'image/gif') {
				exec('gm identify -format "File_size: %b, Unique_colors: %k, Bit_depth: %q, Orig Dimensions: %hx%wpx\n" public/images/original/' . $photoKey);
				exec('gm convert public/images/original/' . $photoKey . ' +dither -depth 8 -colors 135 -coalesce public/images/thumbnail/temp-' . $photoKey);
				exec('gm convert public/images/thumbnail/temp-' . $photoKey . ' +dither -resize 320x320 public/images/thumbnail/' . $photoKey);
				unlink('public/images/thumbnail/temp-' . $photoKey);
			} else {
				exec('gm convert -resize 320x320 public/images/original/' . $photoKey . ' public/images/thumbnail/' . $photoKey);
			}
	
			$addPhoto = $database->prepare("INSERT INTO photos (user_id, key, filename, title) VALUES (:user_id, :key, :filename, :title)");
			$addPhoto->bindValue('user_id', $user->id);
			$addPhoto->bindValue('key', $photoKey);
			$addPhoto->bindValue('filename', $_FILES['upload-photo-file']['name']);
			$addPhoto->bindValue('title', $photoTitle);
			$addPhoto->execute();

			header('Location: /user/dashboard');
			exit;
		}
	}
}

$pageNumber = @$_GET['page'];
if (!$pageNumber) {
	$pageNumber = 1;
}

$photosPerPage = 6;
$getUserPhotos = $database->prepare("SELECT * FROM photos WHERE user_id = ? ORDER BY uploaded_date DESC LIMIT " . ($photosPerPage + 1) . " OFFSET " . (($pageNumber - 1) * $photosPerPage) . "");
$getUserPhotos->execute([$user->id]);
$userPhotos = $getUserPhotos->fetchAll();

$showNextPage = false;
if (count($userPhotos) > $photosPerPage) {
	$showNextPage = true;
	array_pop($userPhotos);
}
