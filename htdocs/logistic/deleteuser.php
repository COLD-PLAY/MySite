<!DOCTYPE html>
<html>
<head>
    <title>删除订单</title>
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

	<?php
	$username = $_POST['username'];

	if ($username) {
		$deluser = new user($username);

		$deluser->start();
		if ($deluser->getstats()) {
			$flag = $deluser->delete();
			if ($flag) {
	    		echo "<script>alert('delete successfully!');</script>";
	    	}
	    	else {
	    		echo "<script>alert('delete failed! please try again');</script>";
	    	}
		}
		else {
			echo "<script>alert('username doesn't exist! please try again');</script>";
		}
		$deluser->close();
	}
	?>

    <div class="box">
        <p id="password" hidden="hidden"><?php echo $password; ?></p>
        <form onsubmit="return checkall(this)" name="deleteuser" action="deleteuser.php" method="post">
            <input type="text" name="username" placeholder="输入待删除的用户名">
            <hr class="line">
            <input type="submit" value="删除">
        </form>
    </div>

    <script type="text/javascript">
        function checkall(f) {
            if (f.username.value == "") {
                alert("请输入完整！");
                return false;
            }
            else if (f.username.value == "root") {
                alert("不能删除root 用户！");
                return false;
            }

            var pass = prompt("输入管理员密码进行此项操作：");
            var password = document.getElementById("password").innerText;
            
            if (pass != password) {
                alert("密码错误！");
                return false;
            }
            return true;
        }
    </script>

</body>
</html>