﻿<?php
require_once ('config.php');

if ($testMySql_pwd != '') {
	if (! isset ( $_POST ['pwd'] ) or  $_POST ['pwd'] != $testMySql_pwd) {
		die ( '<!doctype html>
<html>
<head>
<title>测试MySQL连接_' . $website_name . '</title>
<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/color.css" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
</head>
<body>
	<div class="select">
		<h1>请输入密码</h1>
		<form action="testMySql.php" method="POST">
			<input type="password" class="cmd" id="input_cmd" name="pwd" value="" autofocus="autofocus" />
			<input type="submit" value="确定" />
		</form>
	</div>
</body>
</html>' );
	}
}

function test() {
	global $mysql_server_name, $mysql_username, $mysql_password;
	$result = "";
	
	// 连接到数据库
	$conn = mysql_connect ( $mysql_server_name, $mysql_username, $mysql_password );
	if ($conn === false) {
		$result = '<span class="fail">Could not connect: ' . mysql_error () . '</span>';
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
<link rel="stylesheet" type="text/css" href="style/color.css" />
<link rel="stylesheet" type="text/css" href="style/main.css" />

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