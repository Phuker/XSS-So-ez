<?php
$conn=mysql_connect($mysql_server_name, $mysql_username,$mysql_password); // 创建连接
$db = mysql_select_db($mysql_database, $conn); // 指定查询数据库
?>