<!DOCTYPE html>
<html>
<head>
    <title>添加订单</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
	<?php
	include_once('user.php');
	include_once('order.php');
    include_once('good.php');

	$fromuser = $_GET['username'];

	if ($fromuser) {
		$nowuser = new user($fromuser);
	}
	else {
		$fromuser = $_POST['fromuser'];
		$nowuser = new user($fromuser);

		$fromphonenum = $_POST['fromphonenum'];
		$fromaddress = $_POST['fromaddress'];
		$touser = $_POST['touser'];
		$tophonenum = $_POST['tophonenum'];
		$toaddress = $_POST['toaddress'];

		$ordernum = date('Ymdhi');

        $goodname = $_POST['goodname'];
        $goodnum = $_POST['goodnum'];

		$noworder = new order($fromuser, $fromphonenum, $fromaddress, $touser, $tophonenum, $toaddress, $ordernum, 'wait', $goodname, $goodnum);
        // $nowgood = new good($goodname, $goodnum, $ordernum, $fromuser, $touser, 'wait');

		$noworder->start();
		$flag = $noworder->insert();
		// echo $noworder->getfromuser();

		$noworder->close();

        // $nowgood->start();
        // $flag = $nowgood->insert() and $flag;

        // $nowgood->close();
		if ($flag) {
    		echo "<script>alert('add order successfully!');</script>";
    	}
		else {
			echo "<script>alert('add order failed! please try again');</script>";
		}
	}
	?>
	<div class="box">
        <p id="username" hidden="hidden"><?php echo $fromuser; ?></p>

        <form onsubmit="return checkall(this)" name="addorder" action="addorder.php" method="post">
            <input type="text" name="fromuser" value="<?php echo $nowuser->getusername(); ?>">
            <hr class="line">
            <input type="text" name="fromaddress" placeholder="当前地址" value="<?php echo $nowuser->getaddress(); ?>">
            <hr class="line">
            <input type="text" name="fromphonenum" placeholder="当前电话" value="<?php echo $nowuser->getphonenum() ?>">
            <hr class="line">
            <input type="text" name="touser" placeholder="发送到用户">
            <hr class="line">
            <input type="text" name="toaddress" placeholder="发送到地址">
            <hr class="line">
            <input type="text" name="tophonenum" placeholder="发送到电话">
            <hr class="line">
            <input type="text" name="goodname" placeholder="货物名字">
            <hr class="line">
            <input type="text" name="goodnum" placeholder="货物数量">
            <hr class="line">
            <input type="submit" value="添加">
        </form>
    </div>

    <script type="text/javascript">
        function checkall(f) {
            var username = document.getElementById("username").innerText;
            if (f.fromuser.value == "" || f.fromaddress.value == "" || f.fromphonenum.value == "" || f.touser.value == "" || f.toaddress.value == "" || f.tophonenum == "" || f.goodname == "" || f.goodnum == "") {
                alert("请填写完整！");
                return false;
            }
            else if (username != f.fromuser.value) {
                alert("必须使用您的用户名添加订单！");
                return false;
            }
            else if (isNaN(parseInt(f.fromphonenum.value)) || isNaN(parseInt(f.tophonenum.value))) {
                alert("电话号码必须为数字！");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>