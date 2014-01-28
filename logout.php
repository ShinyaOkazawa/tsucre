<?php
session_start();
session_destroy();
header('Location: http://localhost/job/login-page.php');
?>