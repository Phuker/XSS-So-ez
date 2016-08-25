<?php
$DB_HOST = 'localhost'; // 数据库服务器名称
$DB_PORT = 3306;
$DB_USERNAME = 'username'; // 连接数据库用户名
$DB_PASSWORD = 'password'; // 连接数据库密码
$DB_NAME = 'xss'; // 数据库的名字
$DB_TABLE_NAME = 'xss_data';

// See: http://php.net/manual/zh/pdo.drivers.php
$DB_TYPE = 'mysql';

$DB_DSN = "$DB_TYPE:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;charset=UTF8;"; // data source name
                              
// 密码（不需要请留空：''）
// Password:if don't need,set as ''
$READ_PWD = '';
$WRITE_PWD = ''; //注：如果设置了密码，请修改相应payload。
$BACKDOOR_PWD = '';
$COLOR_PWD = ''; //改变网站配色
$INSTALL_PWD = '';
$TESTDB_PWD = '';

// 网站名称
// Website name
$WEBSITE_NAME = 'XSS So ez';
$WEBSITE_PATH = 'http://www.example.com/xssDev/';  // ends with '/'

// 开发者信息
// Developer Information
$DEV_INFO = '&copy;2016&nbsp;<a href="https://github.com/Phuker/XSS-So-ez" target="_blank">GitHub</a>';
?>