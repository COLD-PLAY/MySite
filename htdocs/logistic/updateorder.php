<!DOCTYPE html>
<html>
<head>
    <title>更新订单</title>
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
            <th>货物名字</th>
            <th>货物数量</th>
        </tr>

        <?php
        include_once('order.php');
        include_once('user.php');

        $nowuser = new user('root');
        $nowuser->start();
        $result = $nowuser->getAllOrders();

        $nowuser->close();

        if ($result) {
        	while ($order = $result->fetch()){
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
        	echo "<tr><td>no orders</td></tr>";
        }
        ?>

        <?php

        $ordernum = $_POST['ordernum'];
        $new_status = $_POST['new_status'];
        $trucknum = $_POST['trucknum'];

        if ($ordernum and $new_status) {
        	$noworder = new order($ordernum);

            if (!$noworder->getflag()) {
                echo "<script>alert('there's not the order you wanno update!');</script>";
            }

            else {
            	$noworder->start();
            	$flag = $noworder->update($new_status, $trucknum);

            	$noworder->close();
            	if ($flag) {
    	    		echo "<script>alert('update successfully!');</script>";
    	    	}
    	    	else {
    	    		echo "<script>alert('update failed! please try again');</script>";
    	    	}
            }
        }
        ?>

    </table>
    <div class="box">
        <form onsubmit="return checkall(this)" name="udpateorder" action="updateorder.php" method="post">
            <input type="text" name="ordernum" placeholder="订单号">
            <hr class="line">
            <input type="text" name="new_status" placeholder="修改当前状态">
            <hr class="line">
            <input type="text" name="trucknum" placeholder="选择运货货车">
            <hr class="line">
            <input type="submit" value="修改">
        </form>
    </div>

    <script type="text/javascript">
        function checkall(f) {
            if (f.ordernum.value == "" || f.status.value == "" || f.trucknum.value == "") {
                alert("请填写完整后提交！");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>