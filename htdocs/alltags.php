<?php
	$mydb = $_GET['db'];

	$conn = new MongoClient();

	$db  = $conn->selectDB("$mydb");
	$list = $db->listCollections();
	
	foreach ($list as $value) {
		# code...
		$value = explode('.', $value)[1];
	}

	$string = implode($list);
	echo $string;
?>