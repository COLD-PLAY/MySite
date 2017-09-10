<!DOCTYPE html>
<html>
<head>
    <title>搜索订单</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
    <?php 
    include_once('user.php');
    $nowusername = $_GET['username'];
    if (!$nowusername)
        $nowusername = $_POST['nowuser'];

    $phonenum = $_POST['phonenum'];
    $ordernum = $_POST['ordernum'];
    $username = $_POST['username'];

    $nowuser = new user($nowusername);
    ?>
    <div class="box">
        <form onsubmit="return checkall(this)" name="searchorder" action="searchorder.php" method="post">
            <input type="text" name="nowusername" hidden="hidden" value="<?php echo $nowusername; ?>" >
            <input type="text" name="phonenum" placeholder="电话号码">
            <hr class="line">
            <input type="text" name="ordernum" placeholder="订单号">
            <hr class="line">
            <input type="text" name="username" placeholder="用户名">
            <hr class="line">
            <input type="submit" value="搜索" style="width: 110%;">
        </form>
    </div>
    <table align="center" style="color: #555555;" cellspacing="5px">
        <tr>
            <th>发送用户</th>
            <th>电话号码</th>
            <th>地址</th>
            <th>接收用户</th>
            <th>电话号码</th>
            <th>地址</th>
            <th>订单号</th>
            <th>当前状态</th>
            <th>货物名字</th>
            <th>货物数量</th>
        </tr>
        <?php
        if ($phonenum or $ordernum or $username) {
            // echo "$phonenum $ordernum $username";
            $nowuser->start();
            $result = $nowuser->search($phonenum, $ordernum, $username);

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
                echo "<tr><td>no orders</td></tr>";
            }
            $nowuser->close();
        }
        ?>
    </table>
    <a href="index.jsp" class="backhome">back</a>

    <script type="text/javascript">
        function checkall(f) {
            if (f.phonenum.value == "" && f.ordernum.value == "" && f.username.value == "") {
                alert("请至少填写一项搜索项！");
                return false;
            }
            else if (f.phonenum.value != "" && isNaN(parseInt(f.phonenum.value)) || f.ordernum.value != "" && isNaN(parseInt(f.ordernum.value))) {
                alert("电话号码或者 订单号必须为数字！");
                return false;
            }
            return true;
        }
    </script>

</body>
</html>