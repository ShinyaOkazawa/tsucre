<?php

require_once 'core/init.php';

// register
if(isset($_POST["register"])){

	// form data
	$username = sanitize($_POST["username"]);
	$password = sanitize($_POST["password"]);
	$repeatpassword = sanitize($_POST["repeatpassword"]);
	$date = date("Y-m-d");

	// check for existence
	if(!empty($username) && !empty($password) && !empty($repeatpassword)){

		if($password==$repeatpassword){
			// check char length of username
			if(strlen($username)>25){
				echo "Length of username is too long";
			} else {
				// check password length
				if(strlen($password)>25||strlen($password)<6){
					echo "password must be between 6 and 25 characters";
				} else {
					// パスワードの暗号化
					$password = md5($password);
					$repeatpassword = md5($repeatpassword);

					$check = "select * from users where username='$username'";
					$result = mysqli_query($connection, $check);
					$check_num_rows = mysqli_num_rows($result);
					if($check_num_rows===0){
						$query = "insert into users (user_id,username,password, created_date,profile,portfolio_url) values (
							'', '$username','$password', '$date','','')";
						mysqli_query($connection, $query);
						if($result = mysqli_query($connection, $check)){
							while ($row = mysqli_fetch_assoc($result)) {
								$_SESSION["username"] = $row["username"];
								$_SESSION["user_id"] = $row["user_id"];
							}
						};	

						header('Location: http://localhost/tsucre/index.php');
						exit();
					} else {
						
					}
				}
			} 
		} else {
			echo "Your passwords do not match";
		}
	} else {
		echo "全ての項目を入力してください";
	}

}
// login
if(isset($_POST["login"])){

	// form data
	$username = sanitize($_POST["username"]);
	$password = sanitize($_POST["password"]);
	$password = md5($password);

	// check whether fill out form
	if(!empty($username) && !empty($password) ){

		$connection = mysqli_connect('localhost', 'root', 'root');
		mysqli_set_charset($connection, 'utf8');
		mysqli_select_db($connection, 'job');

		$query = "select * from users where username='$username'";
		$result = mysqli_query($connection, $query);
		$check_num_rows = mysqli_num_rows($result);
		if($check_num_rows == 1){

			// 入力されたユーザ名に対するパスワードが合っているかチェック

			while ($row = mysqli_fetch_assoc($result)) {
			    $_SESSION["user_id"] = $checkId = $row["user_id"];
			    $_SESSION["username"] = $checkUsername = $row["username"];
			    $_SESSION["password"] = $checkPassword = $row["password"];
			}
			if($password == $checkPassword){
				header('Location: http://localhost/tsucre/index.php');
			}

		} else {
			echo "入力が間違っています";
		}
	
	} else {
		echo "全ての項目を入力してください";
	}

}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>TSUCRE</title>
<link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/style.css">
<link href='http://fonts.googleapis.com/css?family=Karla:700' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="modal">
<div class="background"></div>
<div class="container"></div>
</div><!-- modal end -->
<div id="login-wrapper">
<div id="login-logo">
<img src="images/logo_white.png" height="140" width="140">
<p>TSUCRE</p>
</div>
<header id="login-header">
<h1>すべてのクリエイターたちへ<br>あなたの作品を見せてください</h1>
</header>
<section>
<p>あなたの作品で感動したい人がいます。<br>一生眠らせておくつもりですか？</p>
</section>
<section>
<p><a href="modal/register.php" class="modal"><button id="register" type="button" value="">新規の方</button></a></p>
<p><a href="modal/member-login.php" class="modal"><button id="login" type="button" value="">会員の方</button></a></p>
</section>
<section id="goethe">
<!--<img src="images/quote.jpg" width="24px" height="24px">-->
<q>芸術家よ語るなかれ。造れ。</q>
<p>ゲーテ</p>
</section>
</div><!-- login-wrapper end -->
<script src="js/jquery-2.0.3.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>