<?php
require_once 'functions/config.php';
require_once 'core/init.php';

$user_id = $_SESSION['user_id'];

$query = "select small_thumbnail from image where user_id = $user_id";
$result = mysqli_query($connection, $query);

$images = array();
while($row = mysqli_fetch_assoc($result)){
	$images[] = $row["small_thumbnail"];
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>TSUCRE</title>
<link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="css/portfolio.css">
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
<p class="page-title">PORTFOLIO</p>

<form method="post" enctype="multipart/form-data" action="portfolio-upload.php">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
画像のファイル名を入力してください（最大300KB）
<input size="30" type="file" name="image">
<input type="submit" name="upload" value="upload">
</form>

<?php foreach ($images as $image) : ?>
<img src="<?php echo $image; ?>">
<?php endforeach; ?>

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
</div><!-- footer-right -->
</footer>



</article>
</div><!-- wrapper -->

<script src="js/jquery-2.0.3.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>