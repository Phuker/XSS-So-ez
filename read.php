﻿<?php
require_once ('config.php');
require_once ('db.php');
if ($read_pwd != '' && $_GET ['pwd'] != $read_pwd) {
	die ( 'Who are you? Password requierd.' );
}
?>
<!doctype html>
<html>
<head>
<title>读取数据库_<?php echo $website_name; ?></title>

<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="color.css" />
<style type="text/css">
body {
	margin: 0;
	padding: 0;
	font-family: Consolas,Monaco,Courier,Monospace;
}

div {
	padding: 20px 30px 20px 30px;
	margin: 1em 0.5em 1em 0.5em;
	border-radius: 1em;
	min-height: 75%; /*数据不足撑起页面*/
}
/*吐槽：搞这个表格真是费劲。今天学习不少CSS，还加了一个switch...case...，坑爹。*/
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
</style>
</head>

<body>
	<div>
		<h1>数据库内容</h1>
<?php
require_once ('config.php');
require_once ('db.php');

// info表专用
function show_table_info($result) {
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
			switch ($i) {
				case 0 : // id
					echo '<td style="word-break: keep-all;">';
					break;
				case 1 : // time
					echo '<td style="word-break: keep-all;">';
					break;
				case 2 : // domain
					echo '<td style="word-break: keep-all;">';
					break;
				default :
					echo '<td style="word-break: break-all;">';
					break;
			}
			// echo '<td>';
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

// 从表中提取信息的sql语句
$sql = "SELECT * FROM `info`";
// 执行sql查询
$result = mysql_query ( $sql );
if ($result !== false) {
	// SELECT，SHOW，DESCRIBE, EXPLAIN 等 结果显示（测试可以）
	if (gettype ( $result ) == 'resource') {
		show_table_info ( $result );
	}
} else {
	echo '<span class="fail">执行SQL失败，错误信息：' . mysql_error () . '</span><br/>';
}
?>
<?php echo '<p>'.$dev_info.'</p>';?>
</div>
</body>
</html>