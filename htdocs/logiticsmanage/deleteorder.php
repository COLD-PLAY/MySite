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

    <?php
    $nowuser = new user('root');
    $password = $nowuser->getpassword();

    $ordernum = $_POST['ordernum'];

    if ($ordernum) {
	    $noworder = new order($ordernum);

	    $noworder->start();
	    $flag = $noworder->delete();

	    $noworder->close();
    	if ($flag) {
    		echo "<script>alert('delete successfully!');</script>";
    	}
    	else {
    		echo "<script>alert('delete failed! please try again');</script>";
    	}
	}
    ?>

    <div class="box">
        <p id="password" hidden="hidden"><?php echo $password; ?></p>
        <form onsubmit="return checkall(this)" action="deleteorder.jsp" name="deleteorder" method="post">
            <input type="text" name="ordernum" placeholder="订单号">
            <hr class="line">
            <input type="submit" value="删除">
        </form>
    </div>

    <script type="text/javascript">
        function checkall(f) {
            if (f.ordernum.value == "") {
                alert("请填写完整！");
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