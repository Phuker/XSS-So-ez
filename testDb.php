﻿<?php
require_once ('config.php');
require_once('func.inc.php');
handlePwd($TESTDB_PWD);

if(!extension_loaded('pdo')){
	$result = '<span class="fail">PDO extension required! 需要开启PDO扩展</span>';
} else if (!in_array($DB_TYPE, PDO::getAvailableDrivers())){
	$result = "<span class=\"fail\">PDO driver $DB_TYPE required! 需要开启PDO $DB_TYPE 驱动</span>";
} else {
	try{
		$DB = new PDO($DB_DSN, $DB_USERNAME, $DB_PASSWORD);
		$result = '<span class="success">Connect to MySQL succeed!<br />成功连接到数据库！</span>';
	} catch (PDOException $e){
		$result = '<span class="fail">Error connecting to database: ' . $e->getMessage(). '</span>';
	}
}
?>
<!doctype html>
<html>
<head>
<title>测试数据库连接_<?php echo $WEBSITE_NAME; ?></title>

<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" type="text/css" href="style/color.css" />
<link rel="stylesheet" type="text/css" href="style/main.css" />

</head>

<body>
	<div>
		<h1>Test Database Connection</h1>
		<p><?php
		date_default_timezone_set ( 'Asia/Shanghai' );
		echo date ( 'Y-m-d H:i:s' );
		?></p>
		<p><?php echo $result; ?></p>
		<p><a href="index.php">返回首页</a></p>
		<p><?php echo $DEV_INFO;?></p>
	</div>
</body>
</html>