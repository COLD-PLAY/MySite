<?php
	include('conn.php');

	$table = $_GET['table'];
	$username = $_GET['username'];
	$time = $_GET['time'];

	$sql = "INSERT INTO $table (profileUrl, username, content, commentTime) VALUES ('$profileUrl', '$username', '$content', NOW())";

	$sql = "DELETE FROM `$table` WHERE username = '$username' AND commentTime = '$time'";
	mysql_query($sql);

	print_r('insert successfully')
?>