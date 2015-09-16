﻿<?php
require_once ('config.php');
function test() {
	global $mysql_server_name, $mysql_username, $mysql_password;
	$result = "";
	
	// 连接到数据库
	$conn = mysql_connect ( $mysql_server_name, $mysql_username, $mysql_password );
	if ($conn === false) {
		$result = '<span class="success">Could not connect: ' . mysql_error () . '</span>';
	} else {
		$result = '<span class="success">Connect to MySQL succeed!<br />成功连接到数据库！</span>';
		mysql_close ( $conn );
	}
	return $result;
}
?>
<!doctype html>
<html>
<head>
<title>测试MySQL连接_<?php echo $website_name; ?></title>

<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" type="text/css" href="color.css" />
<style type="text/css">
body {
	margin: 0;
	padding: 0;
	font-family: Consolas,Monaco,Courier,Monospace;
}

div {
	width: 800px;
	margin: 5em auto;
	padding: 50px;
	border-radius: 1em;
}

@media ( max-width : 700px) {
	div {
		width: auto;
		margin: 0 auto;
		border-radius: 0;
		padding: 1em;
	}
}
</style>
</head>

<body>
	<div>
		<h1>Test MySQL Connection</h1>
		<p><?php
		date_default_timezone_set ( 'Asia/Shanghai' );
		echo date ( 'Y-m-d H:i:s' );
		?></p>
		<p><?php echo test(); ?></p>
		<p><a href="index.php">返回首页</a></p>
		<p><?php echo $dev_info;?></p>
	</div>
</body>
</html>