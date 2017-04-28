<!DOCTYPE html>
<html>
<head>
    <title>show orders</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
    <table align="center" cellspacing="5px" style="color: #555555;">
        <tr>
            <th>发送用户</th>
            <th>发送用户电话号码</th>
            <th>发送用户地址</th>
            <th>接收用户</th>
            <th>接收用户电话号码</th>
            <th>接收用户地址</th>
            <th>订单号</th>
            <th>当前状态</th>
        </tr>

        <?php
       	include_once('order.php');
        include_once('user.php');

        $nowuser = new user('root');
        $nowuser->start();
        $result = $nowuser->getAllOrders();

        $nowuser->close();

        echo "<tr>";
        if ($result) {
        	while ($order = $result->fetch()){
        		echo "<td>$order[0]</td>";
            	echo "<td>$order[1]</td>";
            	echo "<td>$order[2]</td>";
            	echo "<td>$order[3]</td>";
            	echo "<td>$order[4]</td>";
            	echo "<td>$order[5]</td>";
            	echo "<td>$order[6]</td>";
            	echo "<td>$order[7]</td>";
        	}
        }
        else {
        	echo "<td>no orders</td>";
        }
        echo "</tr>";
        ?>
    </table>
</body>
</html>