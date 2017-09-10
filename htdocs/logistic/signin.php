<!DOCTYPE html>
<html>
<head>
	<title>登录</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
	<div class="box">
        <h1>登录</h1>
        <form onsubmit="return checkall(this)" action="signin.php" name="signin" method="post">
            <input type="text" name="username" placeholder="用户名">
            <hr class="line">
            <input type="password" name="password" placeholder="密码">
            <hr class="line">
            <input type="submit" value="登录" style="width: 110%;">
        </form>
    </div>
    <a href="index.php" class="backhome">back</a>
    
    <?php
    include_once('user.php');
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username and $password) {
    	$nowuser = new user($username);

    	if ($nowuser->getstatus() and $nowuser->getpassword() == $password) {
    		// echo '<script>alert("sign in successfully! jumping to handler page");</script>';
    		echo "<script>window.location.href='handle.php?username=$username'</script>";
    	}
    	else {
    		echo '<script>alert("sign in failed! username wrong or password wrong!");</script>';
    	}
    }
    ?>

    <script type="text/javascript">
        function checkall(f) {
            if (f.username.value == "" || f.password.value == "") {
                alert("请填写完整！");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>