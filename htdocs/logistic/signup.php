<!DOCTYPE html>
<html>
<head>
    <title>注册</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
    <div class="box">
        <h1>注册</h1>
        <form onsubmit="return checkall(this)" name="signup" action="signup.php" method="post">
            <input type="text" name="username" placeholder="用户名">
            <hr class="line">
            <input type="password" name="password" placeholder="密码">
            <hr class="line">
            <input type="password" name="password_repeat" placeholder="再次输入">
            <hr class="line">
            <input type="text" name="phonenum" placeholder="电话号码">
            <hr class="line">
            <input type="text" name="address" placeholder="地址">
            <hr class="line">
            <input type="submit" value="注册">
        </form>
    </div>
    <a href="index.php" class="backhome">back</a>

    <?php
    include_once('user.php');
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phonenum = $_POST['phonenum'];
    $address = $_POST['address'];

    if ($username and $password and $phonenum and $address) {
    	// echo "$username $password $phonenum $address";
    	$nowuser = new user($username);
    	// if the username had been registered
    	if ($nowuser->getstatus())
    		echo "<script>alert('this username had been registered! please change an username');</script>";
    	else {
    		// echo "$username $password $phonenum $address";

    		$nowuser = new user($username, $password, $phonenum, $address);
    		$nowuser->start();
    		$flag = $nowuser->insert();
    		$nowuser->close();
    		if ($flag) {
    			echo "<script>alert('register successfully! jumping to sign in page');</script>";
    			echo "<script>window.location.href='signin.php'</script>";
    		}
    		else {
    			echo "<script>alert('register failed! please try again');</script>";
    		}
    	}
    }
    ?>

    <script type="text/javascript">
        function checkall(f) {
            if (f.username.value == "" || f.password.value == "" || f.password_repeat.value == "" || f.phonenum.value == "" || f.address.value == "") {
                alert("请填写完整！");
                return false;
            }
            else if (f.password.value != f.password_repeat.value) {
                alert("两次输入的密码不一致！");
                return false;
            }
            else if (f.phonenum.value.length < 6) {
                alert("电话号码太短！")
                return false;
            }
            else if (isNaN(parseInt(f.phonenum.value))) {
                alert("电话号码必须为数字！");
                return false;
            }
            else if (f.password.value.length < 8) {
                alert("密码至少八位！");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>