<?php
require_once('config.php');
if ($install_pwd != '') {
	if (! isset ( $_POST ['pwd'] ) or  $_POST ['pwd'] != $install_pwd) {
		die ( '<!doctype html>
<html>
<head>
<title>建立数据库_' . $website_name . '</title>
<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/color.css" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
</head>
<body>
	<div class="select">
		<h1>请输入密码</h1>
		<form action="install.php" method="POST">
			<input type="password" class="cmd" id="input_cmd" name="pwd" value="" autofocus="autofocus" />
			<input type="submit" value="确定" />
		</form>
	</div>
</body>
</html>' );
	}
}
function filter($str) {
	// 转义为HTML Entity
	$str = trim ( htmlspecialchars ( $str, ENT_QUOTES ) );
	$str = str_replace ( '\\', '&#92;', $str );
	$str = str_replace ( '/', '&#47;', $str );
	return $str;
}
require_once('db.php');?>
<!doctype html>
<html>
<head>
<title>建立数据库_<?php echo $website_name; ?></title>
<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/color.css" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
</head>

<body>
	<div class="select">
		<h1>请选择建立数据库项目</h1>
		<p>配置文件为config.php。默认选项认为已经建立了名为“<?php echo($mysql_database);?>”的数据库。
	如果没有，请选择先建立数据库，然后建立表。 </p>
		<form action="install.php" method="post" class="withBorder">
			<input type="hidden" name="pwd" value="<?php echo filter($_POST ['pwd']);?>">
			<input type="radio" name="type" value="both" />
		建立“<?php echo($mysql_database);?>”数据库，并建立表<br /> <input type="radio"
				name="type" value="db" />
		仅建立“<?php echo($mysql_database);?>”数据库<br /> <input type="radio"
				name="type" value="table" checked="checked" /> 仅建立表<br /> <input
				type="submit" value="确定" />
		</form>
	</div>
	<hr />
	<div class="console">
		<p>
<?php
function createDb() {
	global $mysql_database, $conn;
	$sql = 'create database ' . $mysql_database;
	echo '即将创建数据库……<br/>';
	echo 'SQL命令为：' . $sql . '<br/>';
	$result = mysql_query ( $sql );
	echo '命令执行完毕。<br/>';
	// var_dump($result); //bool(true) or bool(false)
	if ($result !== false) {
		echo '<span class="success">创建数据库成功！</span><br/>';
	} else {
		echo '<span class="fail">创建数据库失败，错误信息：' . mysql_error () . '</span><br/>';
	}
}
function createTable() {
	global $mysql_database, $conn;
	$db = mysql_select_db ( $mysql_database, $conn );
	
	$sql = 'create table info(
id int(10) unsigned NOT NULL AUTO_INCREMENT,
time datetime NOT NULL,
domain nvarchar(50) NOT NULL,
location longtext NULL,
toplocation longtext NULL,
cookie longtext NULL,
opener longtext NULL,
primary key (id)
);';
	/*
	 * config表，可以在线调整设置。由于网站比较简，暂时不用。如需使用，可以用foreach遍历一个数组。foreach ($sqls as $sql)
	 * 'create table config(
	 * id int(10) unsigned NOT NULL AUTO_INCREMENT,
	 * item nvarchar(50) NOT NULL,
	 * value nvarchar(50) NOT NULL,
	 * primary key (id)'
	 */
	echo '即将创建表<br/>';
	echo 'SQL命令为：' . $sql . '<br/>';
	
	$result = mysql_query ( $sql );
	echo '命令执行完毕。<br/>';
	if ($result !== false) {
		echo '<span class="success">创建表成功！</span><br/>';
	} else {
		echo '<span class="fail">创建表失败，错误信息：' . mysql_error () . '</span><br/>';
	}
}

if(isset($_POST['type'])){
	if ($_POST ['type'] == 'both') {
		createDb ();
		createTable ();
	} elseif ($_POST ['type'] == 'db') {
		createDb ();
	} elseif ($_POST ['type'] == 'table') {
		createTable ();
	}
}
 else {
	echo '等待命令。<br />';
}
?>
</p>
		<p>
			<a href="testMySql.php" target="_blank">测试数据库连接</a>&nbsp;<a
				href="index.php">返回首页</a><br /><?php echo $dev_info;?></p>
	</div>
</body>
</html>