<?php

	$mydb = $_GET['db'];
	$mycoll = $_GET['coll'];
	$start = $_GET['start'];

	$conn = new MongoClient();
	$db  = $conn->selectDB("$mydb");

	$collection = $db->selectCollection("$mycoll");

	// 查询条件
	$cursor = $collection->find()->skip($start)->limit(10);

	echo $cursor->count();

	$array = iterator_to_array($cursor);

	echo json_encode($array, JSON_UNESCAPED_UNICODE);

?>