<?php 
	include('conn.php');

	$table = $_GET['table'];
	$profileUrl = $_GET['profileUrl'];
	$username = $_GET['username'];
	$content = $_GET['content'];

	$table = mysql_real_escape_string($table);
	$profileUrl = mysql_real_escape_string($profileUrl);
	$username = mysql_real_escape_string($username);
	$content = mysql_real_escape_string($content);

	$sql = "INSERT INTO $table (profileUrl, username, content, commentTime) VALUES ('$profileUrl', '$username', '$content', NOW())";
	mysql_query($sql);

	print_r('insert successfully')
?>