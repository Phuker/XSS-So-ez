﻿<?php
require_once ('config.php');
if ($read_pwd != '') {
	if (! isset ( $_POST ['pwd'] ) or $_POST ['pwd'] != $read_pwd) {
		die ( '<!doctype html>
<html>
<head>
<title>读取数据库_' . $website_name . '</title>
<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/color.css" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
</head>
<body>
	<div class="select">
		<h1>请输入密码</h1>
		<form action="read.php" method="POST">
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
require_once ('db.php');
?>
<!doctype html>
<html>
<head>
<title>读取数据库_<?php echo $website_name; ?></title>

<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/color.css" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
<style type="text/css">
	.bs{
		/*break small*/
		word-break: break-all;
		font-size: xx-small;
	}
	.kn{
		/*keep normal-size*/
		word-break: keep-all;
	}
</style>
</head>

<body>
	<div class="datatable">
		<h1>数据库内容</h1>
		<form action="read.php" method="post" class="withBorder">
			<input type="hidden" name="pwd"
				value="<?php echo filter($_POST ['pwd']);?>"> <input type="reset"
				value="撤销" />&nbsp;
			<button
				onclick="var inputs = document.getElementsByTagName('input');for(var i =0;i<inputs.length;i++){if(inputs[i].type== 'text' || inputs[i].type=='datetime-local' || inputs[i].type=='number'){inputs[i].value='';
}}document.getElementById('criteria_id').style.display='none';document.getElementById('criteria_time').style.display='none';document.getElementById('criteria_domain').style.display='none';">清空</button>
			<br /> ID<input type="checkbox" name="criteria[]" value="id"
				<?php if(isset($_POST['criteria']) and in_array('id', $_POST['criteria'])){echo 'checked="checked"';}?>
				onchange="var d=document.getElementById('criteria_id'); if(this.checked){d.style.display='inline';}else{d.style.display='none';}" />
			<div id="criteria_id" class="inline" style="display: <?php if(isset($_POST['criteria']) and in_array('id', $_POST['criteria'])){echo 'inline';}else{echo 'none';}?>; ">
				等于：<input type="number" name="id_equal" style="width: 6em;"
					value="<?php if (isset($_POST['id_equal'])) {echo filter($_POST['id_equal']);}?>" />
				大于：<input type="number" name="id_greater" style="width: 6em;"
					value="<?php if(isset($_POST['id_greater'])){echo filter($_POST['id_greater']);}?>" />
				小于：<input type="number" name="id_less" style="width: 6em;"
					value="<?php if(isset($_POST['id_less'])){echo filter($_POST['id_less']);}?>" />
				大于等于：<input type="number" name="id_greater_equal"
					style="width: 6em;"
					value="<?php if(isset($_POST['id_greater_equal'])){echo filter($_POST['id_greater_equal']);}?>" />
				小于等于：<input type="number" name="id_less_equal" style="width: 6em;"
					value="<?php if(isset($_POST['id_less_equal'])){echo filter($_POST['id_less_equal']);}?>" />
			</div>
			<br /> 时间<input type="checkbox" name="criteria[]" value="time"
				<?php if(isset($_POST['criteria']) and in_array('time', $_POST['criteria'])){echo 'checked="checked"';}?>
				onchange="var d=document.getElementById('criteria_time'); if(this.checked){d.style.display='inline';}else{d.style.display='none';}" />
			<div id="criteria_time" class="inline" style="display: <?php if(isset($_POST['criteria']) and in_array('time', $_POST['criteria'])){echo 'inline';}else{echo 'none';}?>;">
				<input type="datetime-local" name="time_greater_equal"
					value="<?php
					
					if (isset ( $_POST ['time_greater_equal'] )) {
						echo filter ( $_POST ['time_greater_equal'] );
					} else {
						echo '2015-01-01T12:00:00';
					}
					?>" /> ~ <input type="datetime-local" name="time_less_equal"
					value=<?php
					
					if (isset ( $_POST ['time_less_equal'] )) {
						echo filter ( $_POST ['time_less_equal'] );
					} else {
						date_default_timezone_set ( 'Asia/Shanghai' );
						$time = date ( 'Y-m-d H:i:s' );
						$time [10] = 'T';
						echo $time;
					}
					?> />
			</div>
			<br /> 域名<input type="checkbox" name="criteria[]" value="domain"
				<?php if(isset($_POST['criteria']) and in_array('domain', $_POST['criteria'])){echo 'checked="checked"';}?>
				onchange="var d=document.getElementById('criteria_domain'); if(this.checked){d.style.display='inline';}else{d.style.display='none';}" />
			<div id="criteria_domain" class="inline" style="display: <?php if(isset($_POST['criteria']) and in_array('domain', $_POST['criteria'])){echo 'inline';}else{echo 'none';}?>;">
				<input type="text" name="domain" style="width: 30em;"
					value="<?php if(isset($_POST['domain'])){echo filter($_POST['domain']);}?>" />
			</div>
			<br /><b>不使用</b>按id（时间）降序排序<input type="checkbox" name="no_order" value="true"
			<?php if(isset($_POST['no_order']) && $_POST['no_order']==="true"){echo 'checked="checked"'; $orderby='';}
			else {$orderby = ' ORDER BY id DESC';}?> />
			<br /><input type="submit" value="确定" />
			<hr/>
		
<?php
require_once ('config.php');
require_once ('db.php');

// info表专用
function show_table_info($result) {
	// Make sure that $result != False
	echo '共查询到 ' . mysql_num_rows ( $result ) . ' 条记录<br />'."\n";
	echo "<table>\n";
	// 显示字段名称
	echo '<tr>';
	// int mysql_num_fields(resource $result)返回结果集中字段的数目
	for($i = 0; $i < mysql_num_fields ( $result ); $i ++) {
		echo '<th>' . mysql_field_name ( $result, $i );
		echo '</th>';
	}
	echo "<th>操作</th></tr>\n";
	
	// 循环取出
	while ( $row = mysql_fetch_row ( $result ) ) {
		echo "<tr>";
		for($i = 0; $i < mysql_num_fields ( $result ); $i ++) {
			switch ($i) {
				case 0 : // id
				case 1 : // time
				case 2 : // domain
					echo '<td class="kn">';
					break;
				case 3:
				case 4:
				case 5:
				case 6:
					echo '<td class="bs">';
					break;
				default : // others
					echo '<td>';
					break;
			}
			// echo '<td>';
			echo $row [$i];
			echo "</td>\n";
		}
		echo '<td class="kn"><button type="submit" value="'.$row[0].'" name="delete">删除</button></td>'."\n";
		echo "</tr>\n\n";
	}
	
	echo "</table>\n";
	echo '共查询到 ' . mysql_num_rows ( $result ) . ' 条记录<br />';
	
	// 释放资源
	mysql_free_result ( $result );
}
function getWhereStr() {
	if (! isset ( $_POST ['criteria'] )) {
		return '';
	}
	// 条件查询。不知道有没有更简洁的写法。
	$where = '';
	
	// 数组：array (size=2) 0 => string 'id' (length=2) 1 => string 'domain' (length=6)
	$cri = $_POST ['criteria'];
	if (count ( $cri ) > 0) {
		if (in_array ( 'id', $cri )) {
			if (trim ( $_POST ['id_equal'] != '' )) {
				$where .= " and id = '" . filter ( $_POST ['id_equal'] ) . "'";
			}
			if (trim ( $_POST ['id_greater'] != '' )) {
				$where .= " and id > '" . filter ( $_POST ['id_greater'] ) . "'";
			}
			if (trim ( $_POST ['id_less'] != '' )) {
				$where .= " and id < '" . filter ( $_POST ['id_less'] ) . "'";
			}
			if (trim ( $_POST ['id_greater_equal'] != '' )) {
				$where .= " and id >= '" . filter ( $_POST ['id_greater_equal'] ) . "'";
			}
			if (trim ( $_POST ['id_less_equal'] != '' )) {
				$where .= " and id <= '" . filter ( $_POST ['id_less_equal'] ) . "'";
			}
		}
		
		if (in_array ( 'time', $cri )) {
			if (trim ( $_POST ['time_greater_equal'] ) != '') {
				$t = filter ( $_POST ['time_greater_equal'] ); // 用HTML5 datetime-local 获取到的，日期和时间中间有一个T。要换成空格
				$t [10] = ' ';
				$where .= " and time >= '" . $t . "'";
			}
			if (trim ( $_POST ['time_less_equal'] ) != '') {
				$t = filter ( $_POST ['time_less_equal'] );
				$t [10] = ' ';
				$where .= " and time <= '" . $t . "'";
			}
		}
		
		if (in_array ( 'domain', $cri ) and trim ( $_POST ['domain'] ) != '') {
			$where .= " and domain = '" . filter ( $_POST ['domain'] ) . "'";
		}
	}
	
	if ($where != '') {
		$where = ' where' . substr ( $where, 4 );
	}
	return $where;
}

// 删除操作
if(isset($_POST['delete']) and !empty($_POST['delete']) and ctype_digit($_POST['delete'])){
	$sql = 'DELETE FROM info WHERE id = '. $_POST['delete'];
	if(mysql_query($sql)){
		echo '<span class="success">执行了删除id为' . $_POST['delete']. '的数据，删除了' . mysql_affected_rows() . '行数据</span><br />';
		echo '执行的SQL 语句为：'.$sql.'<br />';
	}
	else{
		echo '<span class="fail">删除失败，错误信息为：'. mysql_error() .'</span>';
	}
	echo '<hr />';
}

//查询输出表格
$sql = 'SELECT * FROM `info`' . getWhereStr () . $orderby;
echo '执行的SQL语句为：' . $sql . '<br />';

// 执行sql查询
$result = mysql_query ( $sql );
if ($result !== false) {
	// SELECT，SHOW，DESCRIBE, EXPLAIN 等 结果显示（测试可以）
	if (gettype ( $result ) == 'resource') {
		echo '为便于阅读，location等已被解码，再次使用请编码：& => %26, + => %2b<br />'."\n";
		show_table_info ( $result );
	}
} else {
	echo '<span class="fail">执行SQL失败，错误信息：' . mysql_error () . '</span><br/>';
}
?>
</form>
<p>
			<a href="testMySql.php" target="_blank">测试数据库连接</a>&nbsp; <a
				href="index.php">返回首页</a><br />
<?php echo $dev_info;?></p>
	</div>
</body>
</html>