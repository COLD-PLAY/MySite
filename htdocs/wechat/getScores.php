<?php
	$username = $_GET['username'];
	$password = $_GET['password'];

	//初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, "localhost:20480/cj?username=$username&password=$password");
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 1);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);

    $data_r = explode("_____", $data);
    
    //显示获得的数据
    print_r($data_r[1]);
?>