<html>
<head>
    <title>用户</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
    <div style="color: #555555;">
        <table align="center" cellspacing="5px">
            <tr>
                <td>发送用户</td>
                <td>发送用户电话号码</td>
                <td>发送用户地址</td>
                <td>接收用户</td>
                <td>接收用户电话号码</td>
                <td>接收用户地址</td>
                <td>订单号</td>
                <td>当前状态</td>
                <th>货物名字</th>
                <th>货物数量</th>
            </tr>
            <?php
            include_once('user.php');
           	$username = $_GET['username'];
            $nowuser = new user($username);

            if ($username == 'root') {
            	echo "<tr><td>under root</td></tr>";
            }

            else {
	            // start the connection
	            $nowuser->start();
	            $result = $nowuser->getOrders();
	            if ($result) {
		            while ($order = $result->fetch()) {
                        echo "<tr>";
		            	echo "<td>$order[0]</td>";
		            	echo "<td>$order[1]</td>";
		            	echo "<td>$order[2]</td>";
		            	echo "<td>$order[3]</td>";
		            	echo "<td>$order[4]</td>";
		            	echo "<td>$order[5]</td>";
		            	echo "<td>$order[6]</td>";
		            	echo "<td>$order[7]</td>";
                        echo "<td>$order[8]</td>";
                        echo "<td>$order[9]</td>";
                        echo "</tr>";
		            }
		        }
		        else {
		        	echo "<tr><td>no orders now</td></tr>";
		        }
	            // close the connection
	            $nowuser->close();
	        }
            ?>
		</table>
	</div>

    <div class="box">
	    <h1>欢迎， <?php echo $username; ?></h1>
	    <hr class="line">

        <div>
            <a href="addorder.php?username=<?php echo $username; ?>" class="jump" target="_blank">添加订单</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="searchorder.php?username=<?php echo $username; ?>" class="jump" target="_blank">搜索订单</a>
            <hr class="line">
            <a href="updateuser.php?username=<?php echo $username; ?>" class="jump">修改信息</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
                if ($username == 'root') {
                    echo "<a class=\"jump\" href=\"waitgoods.php\" target=\"_blank\">待运货物</a><hr class=\"line\">";
                    echo "<a class=\"jump\" href=\"waittrucks.php\" target=\"_blank\">空闲货车</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "<a class=\"jump\" href=\"updateorder.php\" target=\"_blank\">更新订单</a><hr class=\"line\">";
                    echo "<a class=\"jump\" href=\"deleteorder.php\" target=\"_blank\">删除订单</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "<a class=\"jump\" href=\"showorders.php\" target=\"_blank\">查看订单</a><hr class=\"line\">";
                    echo "<a class=\"jump\" href=\"deleteuser.php\" target=\"_blank\">删除用户</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "<a class=\"jump\" href=\"showusers.php\" target=\"_blank\">查看用户</a><hr class=\"line\">";
                    echo "<a class=\"jump\" href=\"worktrucks.php\" target=\"_blank\">查看正在运输货车</a><hr class=\"line\">";
                }
                else {
                    echo "<a class=\"jump\" href=\"logout.php?username=$username\">注销账户</a><hr class=\"line\">";
                }
            ?>
        </div>
    </div>
    <a href="index.php" class="backhome">back</a>
</body>
</html>