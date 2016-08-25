﻿<?php
require_once ('config.php');
require_once('func.inc.php');
handlePwd($READ_PWD);
require_once ('db.php');

function cssDisplay($inputName){
	if(isset($_POST['criteria']) and in_array($inputName, $_POST['criteria'])){
		echo 'inline';
	}else{
		echo 'none';
	}
}
function checked($id){
	if(isset($_POST['criteria']) && is_array($_POST['criteria']) && in_array($id, @$_POST['criteria'])){
		echo 'checked="checked"';
	}
}
?>
<!doctype html>
<html>
<head>
<title>读取数据库_<?php echo $WEBSITE_NAME; ?></title>

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
<script type="text/javascript">
	function clearForm(){
		var inputs = document.getElementsByTagName('input');
		for(var i =0;i<inputs.length;i++){
			if(inputs[i].type== 'text' || inputs[i].type=='datetime-local' || inputs[i].type=='number'){
				inputs[i].value='';
			}
		}
		document.getElementById('criteria_id').style.display='none';
		document.getElementById('criteria_time').style.display='none';
		document.getElementById('criteria_domain').style.display='none';
		return false;
	}
	function toggleElementShow(id, doShow){
		var d=document.getElementById(id);
		if(doShow){
			d.style.display='inline';
		} else {
			d.style.display='none';
		}
	}
</script>
	<div class="datatable">
		<h1>数据库内容</h1>
		<form action="read.php" method="post" class="withBorder">
			<input type="hidden" name="pwd" value="<?php echo filter(@$_POST ['pwd']);?>" />
			<input type="reset"	value="撤销" />&nbsp;
			<button onclick="return clearForm();">清空</button>
			<br /> 
			ID<input type="checkbox" name="criteria[]" value="id" <?php checked('id'); ?>
				onchange="toggleElementShow('criteria_id',this.checked);" />
			<div id="criteria_id" class="inline" style="display: <?php cssDisplay('id'); ?>; ">
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
			<br />
			时间<input type="checkbox" name="criteria[]" value="time" <?php checked('time'); ?>
				onchange="toggleElementShow('criteria_time',this.checked);" />
			<div id="criteria_time" class="inline" style="display: <?php cssDisplay('time');?>;">
				<input type="datetime-local" name="time_greater_equal"
					value="<?php
					if (isset ( $_POST ['time_greater_equal'] )) {
						echo filter ( $_POST ['time_greater_equal'] );
					} else {
						echo '2015-01-01T12:00:00';
					}
					?>" /> ~ 
					<input type="datetime-local" name="time_less_equal" value="<?php
					if (isset ( $_POST ['time_less_equal'] )) {
						echo filter ( $_POST ['time_less_equal'] );
					} else {
						date_default_timezone_set ( 'Asia/Shanghai' );
						$time = date ( 'Y-m-d H:i:s' );
						$time [10] = 'T';
						echo $time;
					}
					?>" />
			</div>
			<br />
			域名<input type="checkbox" name="criteria[]" value="domain" <?php checked('domain');?>
				onchange="toggleElementShow('criteria_domain',this.checked);" />
			<div id="criteria_domain" class="inline" style="display: <?php cssDisplay('domain');?>;">
				<input type="text" name="domain" style="width: 30em;"
					value="<?php if(isset($_POST['domain'])){echo filter($_POST['domain']);}?>" />
			</div>
			<br /><b>不使用</b>按id（时间）降序排序<input type="checkbox" name="no_order" value="true"
			<?php if(isset($_POST['no_order']) && $_POST['no_order']==="true"){echo 'checked="checked"'; $orderby='';}
			else {$orderby = ' ORDER BY id DESC';}?> />
			<br />
			<input type="submit" value="确定" />
			<hr/>
		
<?php
// 删除操作
if(isset($_POST['delete']) and !empty($_POST['delete']) and ctype_digit($_POST['delete'])){
	$sql = "DELETE FROM $DB_TABLE_NAME WHERE id = {$_POST['delete']}";
	if($DB->exec($sql) === 1){
		echo '<span class="success">成功删除id为' . $_POST['delete']. '的数据</span><br />';
	}
	else{
		echo '<span class="fail">删除失败，错误信息为：';
			var_dump($DB->errorInfo());
		echo '</span><br/>';
	}
	echo '<hr />';
}

//查询输出表格
$bindValues = [];
$where = '';
if (isset ( $_POST ['criteria'] )) {
	// 数组：array (size=2) 0 => string 'id' (length=2) 1 => string 'domain' (length=6)
	$cri = $_POST ['criteria'];
	if (count ( $cri ) > 0) {
		if (in_array ( 'id', $cri )) {
			if (trim ( $_POST ['id_equal'] !== '' )) {
				$where .= " and id = :idE";
				$bindValues[':idE'] = $_POST ['id_equal'];
			}
			if (trim ( $_POST ['id_greater'] !== '' )) {
				$where .= " and id > :idG";
				$bindValues[':idG'] = $_POST ['id_greater'];
			}
			if (trim ( $_POST ['id_less'] !== '' )) {
				$where .= " and id < :idL";
				$bindValues[':idL'] = $_POST ['id_less'];
			}
			if (trim ( $_POST ['id_greater_equal'] !== '' )) {
				$where .= " and id >= :idGE";
				$bindValues[':idGE'] = $_POST ['id_greater_equal'];
			}
			if (trim ( $_POST ['id_less_equal'] !== '' )) {
				$where .= " and id <= :idLE";
				$bindValues[':idLE'] = $_POST ['id_less_equal'];
			}
		}
		
		if (in_array ( 'time', $cri )) {
			if (trim ( $_POST ['time_greater_equal'] ) != '') {
				$t = $_POST ['time_greater_equal']; // 用HTML5 datetime-local 获取到的，日期和时间中间有一个T。要换成空格
				$t [10] = ' ';
				$where .= " and time >= :timeGE";
				$bindValues[':timeGE'] = $t;
			}
			if (trim ( $_POST ['time_less_equal'] ) != '') {
				$t = $_POST ['time_less_equal'];
				$t [10] = ' ';
				$where .= " and time <= :timeLE";
				$bindValues[':timeLE'] = $t;
			}
		}
		
		if (in_array ( 'domain', $cri ) and trim ( $_POST ['domain'] ) != '') {
			$where .= " and domain = :domain";
			$bindValues[':domain'] = $_POST ['domain'];
		}
	}
}

if ($where != '') {
	$where = ' where' . substr ( $where, 4 );
}
$sql = "SELECT * FROM `$DB_TABLE_NAME`" . $where . $orderby;
echo '执行的SQL语句为：' . $sql . '<br />';
$stmt = $DB-> prepare($sql);

// 执行sql查询
if ($stmt->execute($bindValues) !== false) {
	// SELECT，SHOW，DESCRIBE, EXPLAIN 等 结果显示（测试可以）
	echo '为便于阅读，location等已被解码，再次使用请编码：& => %26, + => %2b<br />'."\n";
	showTableXSSData ($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
	echo '<span class="fail">执行SQL失败，错误信息：';
	var_dump($stmt->errorInfo());
	echo '</span><br/>';
}
?>
</form>
	<p><a href="testDb.php" target="_blank">测试数据库连接</a>&nbsp;
	<a href="index.php">返回首页</a></p>
	<p><?php echo $DEV_INFO;?></p>
	</div>
</body>
</html>