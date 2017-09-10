<!DOCTYPE html>
<html>
<head>
    <title>show trucks</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
    <table align="center" cellspacing="5px" style="color: #555555;">
        <tr>
            <th>货车司机</th>
            <th>电话号码</th>
            <th>货车车牌</th>
            <th>当前状态</th>
        </tr>

        <?php
        include_once('user.php');

        $nowuser = new user('root');
        $nowuser->start();
        $result = $nowuser->getWaitTrucks();

        $nowuser->close();

        if ($result) {
        	while ($truck = $result->fetch()){
                echo "<tr>";
        		echo "<td>$truck[0]</td>";
            	echo "<td>$truck[1]</td>";
            	echo "<td>$truck[2]</td>";
                echo "<td>$truck[4]</td>";
                echo "</tr>";
        	}
        }
        else {
        	echo "<td>no wait trucks</td>";
        }
        ?>
    </table>
</body>
</html>