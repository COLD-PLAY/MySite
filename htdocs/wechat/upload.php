<?php 
	include('conn.php');

	$table = $_GET['table'];
	$profileUrl = $_GET['profileUrl'];
	$username = $_GET['username'];
	$content = $_GET['content'];

	$sql = "INSERT INTO $table (profileUrl, username, content) VALUES ('$profileUrl', '$username', '$content')";
	mysql_query($sql);

	print_r('insert successfully')
?>