<?php 
	include('conn.php');
	
	$table = $_GET['table'];
	$start = $_GET['start'];

	if (!$conn) 
	{
		die('Could not connect: ' . mysql_error());
	}
	else {
		if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '". $table . "'")) == 1)
		{
			$sql = "SELECT * FROM $table ORDER BY `id` DESC LIMIT $start,10";
			$result = mysql_query($sql);

			while ($row = mysql_fetch_array($result)) {				
				$output[] = array('profileUrl' => $row['profileUrl'], 'username' => $row['username'], 'content' => $row['content']);
			}
			print_r(json_encode($output));
		}

		else
		{
			$sql = "CREATE TABLE $table (id int NOT NULL AUTO_INCREMENT, profileUrl varchar(200), username varchar(20), content varchar(5000), PRIMARY KEY (id))";
		    mysql_query($sql);
		}
	}
?>