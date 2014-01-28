<?php
$connection = mysqli_connect('localhost', 'root', 'root');
mysqli_select_db($connection, 'job');
	
if(isset($_POST['username'])){
	$username = $_POST['username'];
	$query = "select username from users where username = '$username'";
	$check = mysqli_query($connection, $query);
	$check_num_rows = mysqli_num_rows($check);

	if($check_num_rows != 0){
		//echo '無効なIDです。';
		return false;
	}
}

?>