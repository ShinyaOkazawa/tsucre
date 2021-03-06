<?php

require_once 'functions/config.php';
require_once 'core/init.php';

$user_id = $_SESSION['user_id'];

$query = 'select users.username, image.user_id, image.small_thumbnail,image.title,image.image_id, votes.votes from users inner join image on users.user_id = image.user_id left outer join votes on image.image_id = votes.image_id;';

// showin username for testing
echo $_SESSION["username"];

if($result = $connection->query($query)){
	if($result->num_rows){
		while($rows = $result->fetch_object()){
			$works[] = $rows;
		}
	}
}

if(!isset($_POST["vote"])){
	// 投稿前

	// CSRF対策
	if(!isset($_SESSION['token'])){
		$_SESSION['token'] = sha1(uniqid(mt_rand(), true));
	}
} else {
	// 投稿後
	if(empty($_POST['token']) | $_POST['token'] != $_SESSION['token']){
		echo '不正な操作です。';
		exit();
	}
	$imageId = $_POST["vote-hidden"];
	$query = "select image_id from votes where image_id = $imageId";

	$result = mysqli_query($connection, $query);
	$check_num_rows = mysqli_num_rows($result);
	if($check_num_rows === 0){
		// votes tableにimage idがなかった場合、insert
		$query = "insert into votes (vote_id, image_id, votes, remote_addr, user_agent, vote_date) values (
		'','$imageId','1','','',cast(now() as date))";
		mysqli_query($connection, $query);
	} else {
		// votes tableにimage idがあった場合、update
		$query = "update votes set votes = votes+1, vote_date = cast(now() as date) where image_id = $imageId";
		mysqli_query($connection, $query);
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
<link rel="stylesheet" href="css/index-style.css">
<link href='http://fonts.googleapis.com/css?family=Karla:700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Exo+2:200' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="wrapper">

<div id="header-nav-wrapper">
<header id="header">
<div id="logo">
<a href="index.php"><h1>TSUCRE</h1></a>
</div>
</header>
<div id="nav-wrapper">
<div id="mypage">
<a href="http://localhost/tsucre/mypage.php">MY PAGE</a>
</div>
<nav id="various-nav">
<div class="i_wrapper">
<a href="portfolio.php">
<img src="images/i_portfolio_s_off.png" height="40" width="40">
</a>
</div>
<div class="i_wrapper">
<a href="">
<img src="images/i_clipboard_s_off.png" height="40" width="40">
</a>
</div>
<div class="i_wrapper">
<a href="">
<img src="images/i_fb_s_off.png" height="40" width="40">
</a>
</div>
<div class="i_wrapper">
<a href="">
<img src="images/i_google_s_off.png" height="40" width="40">
</a>
</div>
<div class="i_wrapper">
<a href="">
<img src="images/i_pinterest_s_off.png" height="40" width="40">
</a>
</div>
</nav>
<nav id="global-nav">
<ul id="global-nav-left">
<li><a href="#about">ABOUT</a></li>
<li><a href="#">BLOG</a></li>
</ul>
<ul id="global-nav-right">
<li><a href="#">CREATORS</a></li>
<li><a href="#">WORKS</a></li>
</ul>
</nav>
</div><!-- nav-wrapper -->
</div><!-- header-nav-wrapper -->

<article id="article">

<section id="ranking">
<div id="ranking-header">
<div id="switch-month-wrapper">
<a href=""><img id="left-arrow" src="images/left-arrow.png" height="18" width="18"></a>
<p id="ranking-date">DEC 2013</p>
<a href=""><img id="right-arrow" src="images/right-arrow.png" height="18" width="18"></a>
</div><!-- switch-month-wrapper -->
<p id="top5" class="clear-left">TOP5</p>
<p id="ranking-title">The Chart of This Month</p>
</div><!-- ranking-header -->
<div id="ranking-pics-wrapper">

<div id="first" class="float-left">
<div id="first-menu">
<p id="first-menu-number">#1</p>
<p id="first-menu-title">HEAVEN in the dark</p>
<div class="submenu-toggle">
<div class="submenu-bars-wrapper">
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
</div><!-- submenu-bars-wrapper -->
</div><!-- submenu-toggle -->
</div><!-- first-menu -->
<div id="first-ovl">
<div id="first-votes">
<p id="first-votes-title">votes</p>
<p id="first-votes-number">13,040</p>
</div><!-- first-votes -->
<div id="first-creator">
<p id="first-creator-title">CREATOR</p>
<p id="first-creator-name">SHINYA OKAZAWA</p>
</div><!-- first-creator -->
<div class="votes-button">V</div>
<div class="votes-button-hover"></div>
<div class="ovl-sns-wrapper">
<img src="images/i_fb_s_off.png" height="40" width="40">
<img src="images/i_google_s_off.png" height="40" width="40">
<img src="images/i_pinterest_s_off.png" height="40" width="40">
</div>
</div><!-- first-ovl -->
<img class="rank-pic" src="images/first.jpg" height="480" width="480">
</div><!-- first -->

<div id="second-third" class="float-left">
<div id="second" class="float-left nth-rank">
<div class="nth-menu">
<div class="nth-menu-wrapper">
<p class="nth-menu-number">#2</p>
<p class="nth-menu-title">HEAVEN in the dark</p>
</div><!-- nth-menu-wrapper -->
<div class="submenu-toggle">
<div class="submenu-bars-wrapper">
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
</div><!-- submenu-bars-wrapper -->
</div><!-- submenu-toggle -->
</div><!-- nth-menu -->
<div class="nth-ovl">
<div class="nth-votes">
<p class="nth-votes-title">votes</p>
<p class="nth-votes-number">13,040</p>
</div><!-- nth-votes -->
<div class="nth-creator">
<p class="nth-creator-title">CREATOR</p>
<p class="nth-creator-name">SHINYA OKAZAWA</p>
</div><!-- nth-creator -->
<div class="votes-button">V</div>
<div class="votes-button-hover"></div>
<div class="ovl-sns-wrapper">
<img src="images/i_fb_s_off.png" height="40" width="40">
<img src="images/i_google_s_off.png" height="40" width="40">
<img src="images/i_pinterest_s_off.png" height="40" width="40">
</div>
</div><!-- nth-ovl -->

<img src="images/second.jpg" height="240" width="240">
</div><!-- second -->

<div id="third" class="float-left nth-rank">
<div class="nth-menu">
<div class="nth-menu-wrapper">
<p class="nth-menu-number">#3</p>
<p class="nth-menu-title">HEAVEN in the dark</p>
</div><!-- nth-menu-wrapper -->
<div class="submenu-toggle">
<div class="submenu-bars-wrapper">
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
</div>
</div><!-- submenu-toggle -->
</div><!-- nth-menu -->
<div class="nth-ovl">
<div class="nth-votes">
<p class="nth-votes-title">votes</p>
<p class="nth-votes-number">13,040</p>
</div><!-- nth-votes -->
<div class="nth-creator">
<p class="nth-creator-title">CREATOR</p>
<p class="nth-creator-name">SHINYA OKAZAWA</p>
</div><!-- nth-creator -->
<div class="votes-button">V</div>
<div class="votes-button-hover"></div>
<div class="ovl-sns-wrapper">
<img src="images/i_fb_s_off.png" height="40" width="40">
<img src="images/i_google_s_off.png" height="40" width="40">
<img src="images/i_pinterest_s_off.png" height="40" width="40">
</div>
</div><!-- nth-ovl -->
<img src="images/third.jpg" height="240" width="240">
</div>
</div><!-- second-third -->

<div id="forth-fifth" class="float-left">

<div id="forth" class="float-left nth-rank">
<div class="nth-menu">
<div class="nth-menu-wrapper">
<p class="nth-menu-number">#4</p>
<p class="nth-menu-title">HEAVEN in the dark</p>
</div><!-- nth-menu-wrapper -->
<div class="submenu-toggle">
<div class="submenu-bars-wrapper">
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
</div>
</div><!-- submenu-toggle -->
</div><!-- nth-menu -->
<div class="nth-ovl">
<div class="nth-votes">
<p class="nth-votes-title">votes</p>
<p class="nth-votes-number">13,040</p>
</div><!-- nth-votes -->
<div class="nth-creator">
<p class="nth-creator-title">CREATOR</p>
<p class="nth-creator-name">SHINYA OKAZAWA</p>
</div><!-- nth-creator -->
<div class="votes-button">V</div>
<div class="votes-button-hover"></div>
<div class="ovl-sns-wrapper">
<img src="images/i_fb_s_off.png" height="40" width="40">
<img src="images/i_google_s_off.png" height="40" width="40">
<img src="images/i_pinterest_s_off.png" height="40" width="40">
</div>
</div><!-- nth-ovl -->
<img src="images/forth.jpg" height="240" width="240">
</div>

<div id="fifth" class="float-left nth-rank">
<div class="nth-menu">
<div class="nth-menu-wrapper">
<p class="nth-menu-number">#5</p>
<p class="nth-menu-title">HEAVEN in the dark</p>
</div><!-- nth-menu-wrapper -->
<div class="submenu-toggle">
<div class="submenu-bars-wrapper">
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
</div>
</div><!-- submenu-toggle -->
</div><!-- nth-menu -->
<div class="nth-ovl">
<div class="nth-votes">
<p class="nth-votes-title">votes</p>
<p class="nth-votes-number">13,040</p>
</div><!-- nth-votes -->
<div class="nth-creator">
<p class="nth-creator-title">CREATOR</p>
<p class="nth-creator-name">SHINYA OKAZAWA</p>
</div><!-- nth-creator -->
<div class="votes-button">V</div>
<div class="votes-button-hover"></div>
<div class="ovl-sns-wrapper">
<img src="images/i_fb_s_off.png" height="40" width="40">
<img src="images/i_google_s_off.png" height="40" width="40">
<img src="images/i_pinterest_s_off.png" height="40" width="40">
</div>
</div><!-- nth-ovl -->
<img src="images/fifth.jpg" height="240" width="240">
</div>
</div><!-- forth-fifth -->

<div id="monthly-theme" class="clear-left">
<p id="monthly-theme-left">今月のテーマ</p>
<p id="monthly-theme-right">少女の溜息：Girl with a sigh</p>
</div>
</section><!-- ranking -->

<section id="about">
<h2 class="section-title">ABOUT</h2>
<p id="motto">私たちはクリエイターを応援します。</p>
<div id="infographic-upper">
<div class="genre">
<div class="genre-img-wrapper">
<img src="images/product.png" height="100" width="100">
</div>
<p class="genre-name">PRODUCT</p>
</div><!-- genre -->
<div class="genre">
<div class="genre-img-wrapper">
<img src="images/web.png" height="100" width="100">
</div>
<p class="genre-name">WEB</p>
</div><!-- genre -->
<div class="genre">
<div class="genre-img-wrapper">
<img src="images/typography.png" height="100" width="100">
</div>
<p class="genre-name">TYPOGRAPHY</p>
</div><!-- genre -->
<div class="genre">
<div class="genre-img-wrapper">
<img src="images/caligraphy.png" height="100" width="100">
</div>
<p class="genre-name">CALIGRAPHY</p>
</div><!-- genre -->
</div><!-- infographic-upper -->

<div id="infographic-bottom" class="clear-left">
<div class="info-desc">
<h3>ランキング</h3>
<div class="info-img-wrapper">
<img src="images/chart.png" height="120" width="120">
</div>
<p class="info-p">ユーザーの投票により、<br>ランキングが形成されます。</p>
</div><!-- info-desc -->
<div class="info-desc">
<h3>ジャンル不問</h3>
<div class="info-img-wrapper">
<img src="images/circle.png" height="120" width="120">
</div>
<p class="info-p">クリエイターは作りたいものを作り、<br>みんなで感動を共感しましょう。</p>
</div><!-- info-desc -->
<div class="info-desc">
<h3>ポートフォリオ</h3>
<div class="info-img-wrapper">
<img src="images/portfolio.png" height="120" width="120">
</div>
<p class="info-p">自分のポートフォリオサイトを<br>持つことができます。</p>
</div><!-- info-desc -->
<div class="info-desc">
<h3>クリップボード</h3>
<div class="info-img-wrapper">
<img src="images/clipboard.png" height="120" width="120">
</div>
<p class="info-p">共感した作品をまとめて<br>自分だけのクリップボードが作れます。</p>
</div><!-- info-desc -->
</div><!-- infographic-bottom -->
</section>

<section id="blog" class="clear-left">
<h2 class="section-title">BLOG</h2>
<div class="blog-article">
<img src="images/blog01.jpg" height="180" width="460">
<div class="blog-article-wrapper">
<h3 class="blog-title">marumaru展示会</h3>
<p class="blog-date">2013.12.20</p>
<p class="blog-author">OKAZAWA</p>
<p class="blog-paragraph">イェー！今日はmarumaruの展示会で日本橋にやってきたぜ！今シーズンの注目アイテムが勢
揃いしてるらしいから、チェックしたら即みなさんにお届けするぜ！そういえば今度...
</p>
<a href="#" class="more">more</a>
</div><!-- blog-article-wrapper -->
</div><!-- blog-article -->
<div class="blog-article">
<img src="images/blog02.jpg" height="180" width="460">
<div class="blog-article-wrapper">
<h3 class="blog-title">NY日記第2弾</h3>
<p class="blog-date">2013.12.18</p>
<p class="blog-author">MURO</p>
<p class="blog-paragraph">どうも、ご無沙汰しております。ムロです。そうみなさんご存知の、「あの」ムロです。今日
はSOHO５番街でのストリートスナップに出かけて参りました。すっかりNYも冬を迎え...</p>
<a href="#" class="more">more</a>
</div><!-- blog-article-wrapper -->
</div><!-- blog-article --><div class="blog-article">
<img src="images/blog03.jpg" height="180" width="460">
<div class="blog-article-wrapper">
<h3 class="blog-title">AUSIE SKIT BOY参上！</h3>
<p class="blog-date">2013.12.08</p>
<p class="blog-author">SKIT BOY</p>
<p class="blog-paragraph">本日快晴！気晴らしに出かけたParkで新しいMy manに出会ったよ〜ん。かなりのbad boy
なんだけど、最高にCoooooool!!!!!なんだ！詳細については、長くなりそうだから...</p>
<a href="" class="more">more</a>
</div><!-- blog-article-wrapper -->
</div><!-- blog-article --><div class="blog-article">
<img src="images/blog04.jpg" height="180" width="460">
<div class="blog-article-wrapper">
<h3 class="blog-title">OVER THE RAINBOW</h3>
<p class="blog-date">2013.12.01</p>
<p class="blog-author">ISHII</p>
<p class="blog-paragraph">ちょうど二時に虹がかかった！何かめでたいことが起こるに違いない。そんな予感がする。田
舎じゃないとこんなにキレイに映ることはないだろうなぁー。今日はいい夢見れそう...</p>
<a href="#" class="more">more</a>
</div><!-- blog-article-wrapper -->
</div><!-- blog-article -->
<div id="blog-arrow-wrapper" class="double-arrow-wrapper clear-left">
<a href=""><img class="double-arrow-left" src="images/double_arrow_left.png" height="19" width="27"></a>
<a href=""><img class="double-arrow-right" src="images/double_arrow_right.jpg" height="19" width="26"></a>
</div><!-- blog-arrow-wrapper -->
</section><!-- blog -->

<section id="creators">
<h2 class="section-title">CREATORS</h2>
<div class="gadget">
<img src="images/gearbox.png" height="38" width="38">
<p>GENRE</p>
<img src="images/search.png" height="38" width="38">
<p>SEARCH</p>
</div><!-- gadget -->

<div id="creators-wrapper">
<div class="creator">
<img src="images/ryoma.jpg" height="200" width="200">
<p class="creator-name">RYOMA</p>
<p class="creator-genre">ARCHITECT</p>
</div><!-- creator -->
<div class="creator">
<img src="images/ryoma.jpg" height="200" width="200">
<p class="creator-name">RYOMA</p>
<p class="creator-genre">ARCHITECT</p>
</div><!-- creator -->
<div class="creator">
<img src="images/ryoma.jpg" height="200" width="200">
<p class="creator-name">RYOMA</p>
<p class="creator-genre">ARCHITECT</p>
</div><!-- creator -->
<div class="creator">
<img src="images/ryoma.jpg" height="200" width="200">
<p class="creator-name">RYOMA</p>
<p class="creator-genre">ARCHITECT</p>
</div><!-- creator -->
<div class="creator">
<img src="images/ryoma.jpg" height="200" width="200">
<p class="creator-name">RYOMA</p>
<p class="creator-genre">ARCHITECT</p>
</div><!-- creator -->
<div class="creator">
<img src="images/ryoma.jpg" height="200" width="200">
<p class="creator-name">RYOMA</p>
<p class="creator-genre">ARCHITECT</p>
</div><!-- creator -->
<div class="creator">
<img src="images/ryoma.jpg" height="200" width="200">
<p class="creator-name">RYOMA</p>
<p class="creator-genre">ARCHITECT</p>
</div><!-- creator -->
<div class="creator">
<img src="images/ryoma.jpg" height="200" width="200">
<p class="creator-name">RYOMA</p>
<p class="creator-genre">ARCHITECT</p>
</div><!-- creator -->
</div><!-- creators-wrapper -->
<div id="creator-arrow-wrapper" class="double-arrow-wrapper clear-left">
<a href=""><img class="double-arrow-left" src="images/double_arrow_left.png" height="19" width="27"></a>
<a href=""><img class="double-arrow-right" src="images/double_arrow_right.jpg" height="19" width="26"></a>
</div><!-- creator-arrow-wrapper -->
</section>

<section id="works">
<h2 class="section-title">WORKS</h2>
<div class="gadget">
<img src="images/gearbox.png" height="38" width="38">
<p>GENRE</p>
<img src="images/search.png" height="38" width="38">
<p>SEARCH</p>
</div><!-- gadget -->
<div class="work-wrapper">

<?php foreach ($works as $work) : ?>

<div class="each-work">
<div class="float-left work">
<div class="work-nth-menu">
<div class="work-nth-menu-wrapper">
<p class="work-nth-menu-title"><?php echo $work->title; ?></p>
</div><!-- work-nth-menu-wrapper -->
<div class="submenu-toggle">
<div class="submenu-bars-wrapper">
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
<div class="submenu-bars"></div>
</div><!-- submenu-bars-wrapper -->
</div><!-- submenu-toggle -->
</div><!-- work-nth-menu -->
<div class="work-nth-ovl">
<div class="work-nth-votes">
<p class="work-nth-votes-title">votes</p>
<p class="work-nth-votes-number">
<?php if(isset($work->votes)){echo $work->votes;}else{echo '0';}; ?>
</p>
</div><!-- work-nth-votes -->
<div class="work-nth-creator">
<p class="work-nth-creator-title">CREATOR</p>
<p class="work-nth-creator-name"><?php echo $work->username; ?></p>
</div><!-- work-nth-creator -->
<div class="votes-button">
<form action="" method="post" id="vote-form">
<input type="submit" name="vote" value="V" onClick="ajax_post(); ">
<input type="hidden" class="vote-hidden" name="vote-hidden" value="<?php echo $work->image_id; ?>">
<input type="hidden" name="token" value="<?php echo sanitize($_SESSION['token']); ?>">
</form>
</div>
<div class="votes-button-hover"></div>
<div class="work-ovl-sns-wrapper">
<img src="images/i_fb_s_off.png" height="40" width="40">
<img src="images/i_google_s_off.png" height="40" width="40">
<img src="images/i_pinterest_s_off.png" height="40" width="40">
</div>
</div><!-- work-nth-ovl -->
<img src="<?php echo $work->small_thumbnail; ?>" class="candidate" data-id="<?php echo $work->image_id; ?>">
</div><!-- work -->
</div><!-- each-work -->

<?php endforeach; ?>

</div><!-- work-wrapper -->
<div id="creator-arrow-wrapper" class="double-arrow-wrapper clear-left">
<a href=""><img class="double-arrow-left" src="images/double_arrow_left.png" height="19" width="27"></a>
<a href=""><img class="double-arrow-right" src="images/double_arrow_right.jpg" height="19" width="26"></a>
</div><!-- creator-arrow-wrapper -->
</section><!-- works -->

<?php include 'footer.php'; ?>
</article>
</div><!-- wrapper -->
<script src="js/jquery-2.0.3.min.js"></script>
<script src="js/main.js"></script>
<script src="js/poll.js"></script>
<script>
$(function(){
	$('.votes-button').click(function(){
		$(this).find('.vote-hidden').val($(this).closest('.work').find('.candidate').data('id'));
	});

 // ajax setup
  $.ajaxSetup({
    url: 'ajaxvote.php',
    type: 'POST',
    cache: 'false'
  });

  // any voting button (up/down) clicked event
  $('.vote').click(function(){
    var self = $(this); // cache $this
    var action = self.data('action'); // grab action data up/down 
    var parent = self.parent().parent(); // grab grand parent .item
    var postid = parent.data('postid'); // grab post id from data-postid
    var score = parent.data('score'); // grab score form data-score

    // only works where is no disabled class
    if (!parent.hasClass('.disabled')) {
      // vote up action
      if (action == 'up') {
        // increase vote score and color to orange
        parent.find('.vote-score').html(++score).css({'color':'orange'});
        // change vote up button color to orange
        self.css({'color':'orange'});
        // send ajax request with post id & action
        $.ajax({data: {'postid' : postid, 'action' : 'up'}});
      }
      // voting down action
      else if (action == 'down'){
        // decrease vote score and color to red
        parent.find('.vote-score').html(--score).css({'color':'red'});
        // change vote up button color to red
        self.css({'color':'red'});
        // send ajax request
        $.ajax({data: {'postid' : postid, 'action' : 'down'}});
      };

      // add disabled class with .item
      parent.addClass('.disabled');
    };
  });
});
});
</script>
</body>
</html>