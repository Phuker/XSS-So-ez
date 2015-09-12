<?php
require_once('config.php');
require_once('db.php'); $pwd = 'My_Be1onging';
if($backdoor_pwd!='' && $_REQUEST['pwd']!=$backdoor_pwd)
{
	die('Who are you? Password requierd.');
}
function filter($str){
	// 转义为HTML Entity
	$str = trim(htmlspecialchars($str,ENT_QUOTES));
	$str = str_replace('\\','&#92;',$str);
	$str = str_replace('/','&#47;',$str);
	return $str;
}
?>
<!doctype html>
<html>
<head>
    <title>后门_<?php echo $website_name; ?></title>
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
    input[type="text"] {
    width: 80%;
}
    </style>
</head>

<body>
<div class="select">
	<h1>执行SQL语句（不支持SELECT结果查看）</h1>
	<form action="backdoor.php?pwd=<?php echo filter($_GET['pwd'])?>" method="post">
		<input type="text" name="sql" />
		<input type="submit" value="确定" />
	</form>
</div>
<hr />
<div class="console">
<p>
<?php
function exeSql($sql){
	global $mysql_database,$conn;
	echo 'SQL命令为：'.$sql.'<br/>';
	$result=mysql_query($sql);
	echo '命令执行完毕。<br/>';
	// var_dump($result); //bool(true) or bool(false)
	if($result)
	{
		echo '<span class="success">执行成功！</span><br/>';
	}
	else
	{
		echo '<span class="fail">创建数据库失败，错误信息：'.mysql_error().'</span><br/>';
	}
}

if ($_POST['sql'] != '') {
	exeSql($_POST['sql']);
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