<?php
require_once 'functions/config.php';
require_once 'core/init.php';

$id = $_SESSION['id'];

// エラーチェック
// 全般
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
// 保存するファイル名
$imageFilePath = ORIGINAL_IMAGE_DIR . $_FILES['image']['name'];

// DBへオリジナル画像のパスを保存
$query = "insert into image (
	image_id, user_id, big_thumbnail, middle_thumbnail, small_thumbnail, original_image) values (
	'', '$id', '', '', '', '$imageFilePath'
	)";
mysqli_query($connection, $query);

// DBからimage_idの取得
$query = "select image_id from image where original_image = '$imageFilePath'";
$result = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $image_id = $row["image_id"];
}

// 画像の各種情報取得
$imagesize = getimagesize($_FILES['image']['tmp_name']);

// 拡張子生成
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
// 名前を生成
$imageFileName = sha1(time().mt_rand()) .$ext;

// 元画像を保存
$imageFilePath = ORIGINAL_IMAGE_DIR . '/' . $imageFileName;

$rs = move_uploaded_file($_FILES['image']['tmp_name'], $imageFilePath);

if(!$rs){
	echo "Could not upload";
	exit();
}
// 縮小画像を作成、保存
$width = $imagesize[0];
$height = $imagesize[1];

if($width > SMALL_THUMBNAIL_WIDTH){

	// 元ファイルを画像タイプによって作る
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

	// 新しいサイズを作る
	$thumbHeight_big = round($height * BIG_THUMBNAIL_WIDTH / $width);
	$thumbHeight_middle = round($height * MIDDLE_THUMBNAIL_WIDTH / $width);
	$thumbHeight_small = round($height * SMALL_THUMBNAIL_WIDTH / $width);

	// 縮小画像を生成
	$thumbImage_big = imagecreatetruecolor(BIG_THUMBNAIL_WIDTH, $thumbHeight_big);
	$thumbImage_middle = imagecreatetruecolor(MIDDLE_THUMBNAIL_WIDTH, $thumbHeight_middle);
	$thumbImage_small = imagecreatetruecolor(SMALL_THUMBNAIL_WIDTH, $thumbHeight_small);

	imagecopyresampled($thumbImage_big, $srcImage, 0, 0, 0, 0, 480, $thumbHeight_big, $width, $height);
	imagecopyresampled($thumbImage_middle, $srcImage, 0, 0, 0, 0, 240, $thumbHeight_middle, $width, $height);
	imagecopyresampled($thumbImage_small, $srcImage, 0, 0, 0, 0, 220, $thumbHeight_small, $width, $height);

	// 縮小画像を保存する
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
	$imageFilePath_big = BIG_THUMBNAIL_DIR . $imageFileName;
	$imageFilePath_middle = MIDDLE_THUMBNAIL_DIR . $imageFileName;
	$imageFilePath_small = SMALL_THUMBNAIL_DIR . $imageFileName;
	$imageFilePath_original = ORIGINAL_IMAGE_DIR . $_FILES['image']['name'];

	$query = "update image set big_thumbnail = '$imageFilePath_big',
	middle_thumbnail = '$imageFilePath_middle',
	small_thumbnail = '$imageFilePath_small' where image_id = $image_id";
	mysqli_query($connection, $query);

}

// mypage.phpに飛ばす
header('Location: http://'.$_SERVER['SERVER_NAME'].'/tsucre/mypage.php');
exit();
?>
