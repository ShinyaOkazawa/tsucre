<?php

function resizeImage($connection,$returnPage){	

	$user_id = $_SESSION['user_id'];

	// エラーチェック
	if($_FILES['image']['error'] != UPLOAD_ERR_OK){
		echo "エラーが発生しました：";
		exit();
	}

	// ファイルサイズチェック
	$size = filesize($_FILES['image']['tmp_name']);
	if(!$size || $size > MAX_FILE_SIZE){
		"ファイルサイズが大きすぎます。";
		exit();
	}
	// 画像情報取得
	$imagesize = getimagesize($_FILES['image']['tmp_name']);
	$width = $imagesize[0];
	$height = $imagesize[1];

	// uploadsディレクトリに保存する名前を生成
	switch($imagesize['mime']){
		case 'image/gif':
			$ext = '.gif';
			break;
		case 'image/jpeg':
			$ext = '.jpg';
			break;
		case 'image/png':
			$ext = '.png';
			break;
		default:
			echo "GIF/JPEG/PNG only!";
			exit();
	}
	$imageFileName = sha1(time().mt_rand()) .$ext;

	// 元画像をステージングからoriginal_imageディレクトリに移動
	$imageFilePath = ORIGINAL_IMAGE_DIR . '/' . $imageFileName;
	$rs = move_uploaded_file($_FILES['image']['tmp_name'], $imageFilePath);

	if(!$rs){
		echo "Could not upload";
		exit();
	}
	// 新しいサイズを作る
	$thumbHeight_big = round($height * BIG_THUMBNAIL_WIDTH / $width);
	$thumbHeight_middle = round($height * MIDDLE_THUMBNAIL_WIDTH / $width);
	$thumbHeight_small = round($height * SMALL_THUMBNAIL_WIDTH / $width);

	// 縮小画像を生成
	$thumbImage_big = imagecreatetruecolor(BIG_THUMBNAIL_WIDTH, $thumbHeight_big);
	$thumbImage_middle = imagecreatetruecolor(MIDDLE_THUMBNAIL_WIDTH, $thumbHeight_middle);
	$thumbImage_small = imagecreatetruecolor(SMALL_THUMBNAIL_WIDTH, $thumbHeight_small);

	// 再サンプル
	switch($imagesize['mime']){
	case 'image/gif':
		$srcImage = imagecreatefromgif($imageFilePath);
		break;
	case 'image/jpeg':
		$srcImage = imagecreatefromjpeg($imageFilePath);
		break;
	case 'image/png':
		$srcImage = imagecreatefrompng($imageFilePath);
		break;
	default:
		echo "GIF/JPEG/PNG only!";
		exit();
	}
	imagecopyresampled($thumbImage_big, $srcImage, 0, 0, 0, 0, 480, $thumbHeight_big, $width, $height);
	imagecopyresampled($thumbImage_middle, $srcImage, 0, 0, 0, 0, 240, $thumbHeight_middle, $width, $height);
	imagecopyresampled($thumbImage_small, $srcImage, 0, 0, 0, 0, 220, $thumbHeight_small, $width, $height);

	// 画像をファイルに出力する
	switch($imagesize['mime']){
	case 'image/gif':
		imagegif($thumbImage_big, BIG_THUMBNAIL_DIR. '/'.$imageFileName);
		imagegif($thumbImage_middle, MIDDLE_THUMBNAIL_DIR. '/'.$imageFileName);
		imagegif($thumbImage_small, SMALL_THUMBNAIL_DIR. '/'.$imageFileName);
		break;
	case 'image/jpeg':
		imagejpeg($thumbImage_big, BIG_THUMBNAIL_DIR. '/'.$imageFileName);
		imagejpeg($thumbImage_middle, MIDDLE_THUMBNAIL_DIR. '/'.$imageFileName);
		imagejpeg($thumbImage_small, SMALL_THUMBNAIL_DIR. '/'.$imageFileName);
		break;
	case 'image/png':
		imagepng($thumbImage_big, BIG_THUMBNAIL_DIR. '/'.$imageFileName);
		imagepng($thumbImage_middle, MIDDLE_THUMBNAIL_DIR. '/'.$imageFileName);
		imagepng($thumbImage_small, SMALL_THUMBNAIL_DIR. '/'.$imageFileName);
		break;
	default:
		echo "GIF/JPEG/PNG only!";
		exit();
	}

	// DBへ保存するパスの生成
	$imageFilePath_big = "uploads/big_thumbnail/".$imageFileName;
	$imageFilePath_middle = "uploads/middle_thumbnail/".$imageFileName;
	$imageFilePath_small = "uploads/small_thumbnail/".$imageFileName;
	$imageFilePath_original = ORIGINAL_IMAGE_DIR . $_FILES['image']['name'];

	// image table にレコードを追加
	$query = "insert into image (image_id, user_id, big_thumbnail, middle_thumbnail, small_thumbnail, original_image) values (
		'','$user_id','$imageFilePath_big','$imageFilePath_middle','$imageFilePath_small','$imageFilePath_original')";
	mysqli_query($connection, $query);

	// image table に最後に追加されたimage_idを取得
	$query = "select image_id from image order by image_id desc limit 1";
	$result = mysqli_query($connection, $query);
	while($row = mysqli_fetch_assoc($result)){
		$_SESSION["image_id"] = $row["image_id"];
	}
	
	header("Location: http://".$_SERVER['SERVER_NAME']."/tsucre/$returnPage");
}
