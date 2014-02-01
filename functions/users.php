<?php

function user_exists($username){
	$username = sanitize($username);
	
	$query = "select * from users where username = '$username'";
	if($query = mysqli_query(mysqli_connect('localhost', 'root', 'root'), $query)){
		$check_num_rows = mysqli_num_rows($query);
		return ($check_num_rows != 0) ? true : false;	
	}
	
}

function logged_in(){
	return (isset($_SESSION["user_id"])) ? true : false;
}
?>