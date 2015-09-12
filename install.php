<?php require_once('config.php'); require_once('db.php');?>
<!doctype html>
<html>
<head>
    <title>建立数据库_<?php echo $website_name; ?></title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <style type="text/css">
    body {
        background-color: #99D9EA;
        margin: 0;
        padding: 0;
    }
    div {
        background-color: #fff;
    }
    div.select{
    	padding: 50px;
    	width: 800px;
    	margin: 3em auto 1em auto;
    	border-radius:1em;
    }
    div.console{
    	padding: 20px;
    	margin: 1em 2em auto 2em; //上右下左
    }
    a:link, a:visited {
        color: #38488f;
        text-decoration: none;
    }
    span.success{
    	background-color: #B5E61D;
    }
    span.fail{
    	background-color: #FF8888;
    }
    form{
    	border-color: #000000;
    	border-width: 1px;
	    border-style: dashed;
	    margin: 0 3em 0 3em;
	    padding: 1em;
    }
    </style>
</head>

<body>
<div class="select">
	<h1>请选择建立数据库项目</h1>
	<p>配置文件为config.php。默认设置为已经建立了名为“<?php echo($mysql_database);?>”的数据库。
	如果没有，请更改选项来建立数据库，然后建立表。 </p>
	<form action="install.php" method="post">
		<input type="radio" name="type" value="both" />
		建立“<?php echo($mysql_database);?>”数据库，并建立表<br />
		<input type="radio" name="type" value="db" />
		仅建立“<?php echo($mysql_database);?>”数据库<br />
		<input type="radio" name="type" value="table" checked="checked"/>
		仅建立表<br />
		<input type="submit" value="确定" />
	</form>
</div>
<hr />
<div class="console">
<p>
<?php
function createDb(){
	global $mysql_database,$conn;
	$sql = 'create database '.$mysql_database;
	echo '即将创建数据库……<br/>';
	echo 'SQL命令为：'.$sql.'<br/>';
	$result=mysql_query($sql);
	echo '命令执行完毕。<br/>';
	// var_dump($result); //bool(true) or bool(false)
	if($result)
	{
		echo '<span class="success">创建数据库成功！</span><br/>';
	}
	else
	{
		echo '<span class="fail">创建数据库失败，错误信息：'.mysql_error().'</span><br/>';
	}
}

function createTable(){
	global $mysql_database,$conn;
	$db = mysql_select_db($mysql_database, $conn);
	
	$sql = 'create table info(
id int(10) unsigned NOT NULL AUTO_INCREMENT,
time datetime NOT NULL,
domain nvarchar(50) NOT NULL,
url longtext NOT NULL,
cookie longtext NULL,
primary key (id)
);';
	
	echo '即将创建表……<br/>';
	echo 'SQL命令为：'.$sql.'<br/>';
	
	$result=mysql_query($sql);
	echo '命令执行完毕。<br/>';
	// var_dump($result); //bool(true) or bool(false)
	if($result)
	{
		echo '<span class="success">创建表成功！</span><br/>';
	}
	else
	{
		echo '<span class="fail">创建表失败，错误信息：'.mysql_error().'</span><br/>';
	}
}

if ($_POST['type'] == 'both') {
	createDb();
	createTable();
}
elseif ($_POST['type'] == 'db'){
	createDb();
}
elseif ($_POST['type'] == 'table'){
	createTable();
}
else{
	echo '等待命令。<br />';
}
?>
</p>
<p><a href="testMySql.php" target="_blank">测试数据库连接</a>&nbsp;<a href="index.php">返回首页</a><br /><?php echo $dev_info;?></p>
</div>
</body>
</html>