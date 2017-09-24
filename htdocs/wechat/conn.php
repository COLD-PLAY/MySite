<?php 
	$host = '119.29.130.217'; # http://119.29.130.217
	$username = 'coldplay';
	$password = 'liaozhou1998';

	$dbname = 'wechat';
	$conn = mysql_connect($host, $username, $password);

	if (!$conn) {
		die('Connect Server Failed: ' . mysql_error($conn));
	}
	else {
		mysql_query("SET NAMES UTF8");
		mysql_select_db($dbname);
	}

?>