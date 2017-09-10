<!DOCTYPE html>
<html>
<head>
    <title>show users</title>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
    <table align="center" cellspacing="5px" style="color: #555555;">
        <tr>
            <th>用户名</th>
            <th>电话号码</th>
            <th>地址</th>
        </tr>
		
		<?php
		include('user.php');
		include('order.php');

		$nowuser = new user('root');
		$password = $nowuser->getpassword();

		$nowuser->start();
		$result = $nowuser->getAllUsers();

		$nowuser->close();

		if ($result) {
			while ($user = $result->fetch()) {
				if ($user[0] == 'root')
					continue;
				echo "<tr>";
				echo "<td>$user[0]</td>";
				echo "<td>$user[2]</td>";
				echo "<td>$user[3]</td>";
				echo "</tr>";
			}
		}
		else {
			echo "<tr><td>no users</td></tr>";
		}
		?>

	</table>

</body>
</html>