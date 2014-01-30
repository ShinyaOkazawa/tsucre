<?php

require_once 'functions/config.php';
require_once 'core/init.php';
require_once 'resize.php';

$id = $_SESSION['id'];

resizeImage($connection);

/*
// 元画像を保存
$imageFilePath = PROFILE_IMAGE_DIR . $imageFileName;

$rs = move_uploaded_file($_FILES['image']['tmp_name'], $imageFilePath);
if(!$rs){
	echo "Could not upload";
	exit();
}


// DBに挿入するパス
$query = "update users set profile = '$imageFilePath' where id = $id";
mysqli_query($connection, $query);
*/
/*
header('Location: http://'.$_SERVER['SERVER_NAME'].'/tsucre/mypage.php');
exit();
*/