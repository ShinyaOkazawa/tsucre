<?php

require_once 'functions/config.php';
require_once 'core/init.php';
require_once 'resize.php';

$user_id = $_SESSION['user_id'];
$returnPage = 'mypage.php';

resizeImage($connection,$returnPage);

