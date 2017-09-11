<?php
	include('conn.php');
	$dbname =  'information_schema';

	mysql_select_db($dbname);	

	$sql = 'SELECT TABLE_NAME FROM TABLES WHERE TABLE_SCHEMA = "wechat" ORDER BY TABLE_ROWS DESC LIMIT 0,4;';
	$result = mysql_query($sql);

	while ($row = mysql_fetch_array($result)) {				
		$output[] = array('tablename' => $row['TABLE_NAME']);
	}
	print_r(json_encode($output));
?>