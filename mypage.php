<?php
require_once 'functions/config.php';
require_once 'core/init.php';

$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];

// 名前とポートフォリオのurlを変更
if(isset($_POST["commit"])){
	$changeName = $_POST["username"];
	$myUrl = $_POST["portfolio"];
	$query = "update users set username = '$changeName', portfolio_url = '$myUrl' where id = $id";
	mysqli_query($connection, $query);
}

$query = "select portfolio_url from users where user_id = $user_id";
$query = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($query)) {
    $_SESSION["portfolio_url"] = $myUrl = $row["portfolio_url"];
}


// usersのprofileにimage_idを挿入
$query = "update users set profile = ".$_SESSION['image_id']. " where user_id = $user_id";
mysqli_query($connection, $query);

// usersのprofileからimageのmiddle thumbnailを取得
$query = "select middle_thumbnail from image where image_id = (select profile from users where user_id = $user_id)";
$query = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($query)){
	$profile = $row["middle_thumbnail"];
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>TSUCRE</title>
<link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="css/mypage.css">
<link href='http://fonts.googleapis.com/css?family=Karla:700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Exo+2:200' rel='stylesheet' type='text/css'>	
</head>
<body>
<div id="wrapper">
<header>
<div id="header-inner-wrapper">
<div id="header-logo">
<a href="index.php">
<img src="images/logo_white_bold.png" height="40" width="40">
</a>
</div>
<h1><a href="index.php">TSUCRE</a></h1>
<nav>
<ul id="global-nav">
<li><a href="about.php">ABOUT</a></li>
<li><a href="blog.php">BLOG</a></li>
<li><a href="creators.php">CREATORS</a></li>
<li><a href="works.php">WORKS</a></li>
</ul>
<ul id="my-nav">
<li><a href="portfolio.php"><img src="images/i_portfolio_s_on.png" height="30" width="30"></a></li>
<li><a href="clipboard.php"><img src="images/i_clipboard_s_on.png" height="30" width="30"></a></li>
</ul>
</nav>
</div><!-- header-inner-wrapper -->
</header>
<article>
<section id="mypage">
<h2>MY PAGE</h2>
<div id="first-form-wrapper">
<h3><span class="meta">Your</span>Avatar</h3>

<form method="post" enctype="multipart/form-data" action="profile-upload.php">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
画像のファイル名を入力してください（最大300KB）
<input size="30" type="file" name="image">
<input type="submit" name="upload" value="upload">
</form>
</div><!-- second-form-wrapper -->
<div id="second-form-wrapper">
<div id="profile">
<img src="<?php echo $profile; ?>">
</div>
<form action="mypage.php" method="post">
<div class="form-field">
<fieldset class="user_name">
<label for="user_name">User Name</label>
<input id="user_name" name="username" size="30" type="text" value="<?php echo $username; ?>">
</fieldset>
</div>
<div class="form-btns">
<input class="form-sub" name="commit" type="submit" value="update Settings">
</div>
</form>
</div><!-- first-form-wrapper -->

</section>

<section id="clipboard">
<h3>CLIPBOARD</h3>

</section>
<footer id="footer">
<div id="footer-left">
<div id="footer-logo">
<a href="#"><h2>TSUCRE</h2></a>
<img src="images/logo_footer.png" height="180" width="180">
</div><!-- footer-logo -->
</div><!-- footer-left -->
<div id="footer-right">
<ul>
<li><a href="#">ABOUT</a></li>
<li><a href="#">BLOG</a></li>
<li><a href="#">CREATORS</a></li>
<li><a href="#">WORKS</a></li>
<li><a href="#">MY PORTFOLIO</a></li>
</ul>
<p>CREDIT BY SOWORK DESIGN</p>
</div>
</footer>

</article>
</div><!-- wrapper -->

<script src="js/jquery-2.0.3.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>