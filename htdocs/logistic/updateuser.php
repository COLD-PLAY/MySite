<!DOCTYPE html>
<html>
<head>
    <title>修改信息</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>

    <table align="center" cellspacing="5px" style="color: #555555;">
        <tr>
            <td>用户名</td>
            <td>电话号码</td>
            <td>地址</td>
        </tr>
        <?php
        include_once('user.php');
        $username = $_GET['username'];
        if (!$username) {
        	$username = $_POST['username'];
        }

        $nowuser = new user($username);

        $phonenum = $nowuser->getphonenum();
        $address = $nowuser->getaddress();

        echo "<tr>";
        echo "<td>$username</td>";
        echo "<td>$phonenum</td>";
        echo "<td>$address</td>";
        echo "</tr>";
        ?>
    </table>
    <div class="box">
        <form onsubmit="return checkall(this)" name="updateuser" action="updateuser.php" method="post">
            <input type="text" name="username" placeholder="用户名（不可更改）" value="<?php echo $username; ?>" hidden="hidden">
            
            <input type="password" name="password" placeholder="原密码（必填）">
            <hr class="line">
            <input type="password" name="new_password" placeholder="新密码（选填）">
            <hr class="line">
            <input type="password" name="new_password_repeat" placeholder="再次输入">
            <hr class="line">
            <input type="text" name="new_phonenum" placeholder="新电话号码（选填）">
            <hr class="line">
            <input type="text" name="new_address" placeholder="新地址（选填）">
            <hr class="line">
            <input type="submit" value="修改">
        </form>
    </div>
    <a href="handle.php<?php echo "?username=$username"; ?>" class="backhome">back</a>
    
    <?php
    $password = $_POST['password'];
    $new_password = $_POST['new_password'];
    $new_phonenum = $_POST['new_phonenum'];
    $new_address = $_POST['new_address'];

    if ($password and ($new_password or $new_phonenum or $new_address)) {
    	$nowuser->start();
        $flag = $nowuser->update($new_password, $new_phonenum, $new_address);
    
        $nowuser->close();
        if ($flag) {
    		echo "<script>alert('update successfully!');</script>";
    		echo "<script>window.location.href='signin.php'</script>";
    	}
    	else {
    		echo "<script>alert('update failed! please try again');</script>";
    	}
    }
    ?>

    <script type="text/javascript">
        function checkall(f) {
            if (f.password.value == "") {
                alert("原密码必须填入！");
                return false;
            }
            else if (f.new_password.value == "" && f.new_phonenum.value == "" && f.new_address.value == "") {
                alert("请至少修改一项！");
                return false;
            }
            else if (f.new_password.value != f.new_password_repeat.value) {
                alert("两次输入的密码不一致！");
                return false;
            }
            else if (f.new_phonenum.value != "" && f.new_phonenum.value.length < 6) {
                alert("电话号码太短！");
                return false;
            }
            else if (f.new_phonenum.value != "" && isNaN(parseInt(f.new_phonenum.value))) {
                alert("电话号码必须为数字！");
                return false;
            }
            else if (f.new_password.value != "" && f.new_password.value.length < 8) {
                alert("密码至少八位！");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>