<?php
include 'core/init.php';


if(empty($_POST) === false){
	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) === true || empty($password) === true){
		$errors[] = 'You need to input a username and password';
	} else if(user_exists($username) === false){
		$errors[] = 'We can\'t find that username. Have you registered?';
	} else if(user_active($username) === false){
		$errors[] = 'You haven\'t activated your account';
	} else {

	}
}


?>