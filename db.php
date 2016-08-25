<?php
if(!extension_loaded('pdo')){
	exit('PDO extension required!');
}
require_once('config.php');
try{
	$DB = new PDO($DB_DSN, $DB_USERNAME, $DB_PASSWORD);
} catch (PDOException $e){
	echo 'Error connecting to database: ' . $e->getMessage(). '<br />';
	die();
}
