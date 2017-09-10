<html>
<head>
    <title>注销账户</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
    <?php
    include('user.php');
    $username = $_GET['username'];
    if (!$username)
        $username = $_POST['username'];

    $nowuser = new user($username);
    $password = $_POST['password'];

    if ($password) {
        $nowuser->start();

        if ($password == $nowuser->getpassword()) {
            $flag = $nowuser->delete();
            if ($flag) {
                echo "<script>alert('log out successfully! jumping to the index home page');</script>";
                echo "<script>window.location.href='index.php'</script>";
            }
            else {
                echo "<script>alert('log out failed! please try again');</script>";
            }
        }
        else {
            echo "<script>alert('the password wrong! please try again');</script>";
        }
        $nowuser->close();
    }
    ?>

    <div class="box">
        <form onsubmit="return checkall(this)" action="logout.jsp" method="post">
            <input type="text" name="username" hidden="hidden" value="<?php echo $username; ?>">
            <input type="password" name="password" placeholder="密码">
            <hr class="line">
            <input type="submit" value="注销" style="width: 100%;">
        </form>
    </div>
    <a href="handle.php<?php echo "?username=$username"; ?>" class="backhome">back</a>

    <script type="text/javascript">
        function checkall(f) {
            if (f.password.value == "") {
                alert("请输入密码！");
                return false;
            }
            var qr = confirm("确定要注销么？");
            return qr;
        }
    </script>
</body>
</html>
