<?php
// charset: UTF-8

// Datebase 数据库
// 以下已配置为新浪云（SAE）可用。代码设计如此：此处将全局变量赋值给局部变量，可能降低性能。
$mysql_server_name = SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT; // 数据库服务器名称
$mysql_username = SAE_MYSQL_USER; // 连接数据库用户名
$mysql_password = SAE_MYSQL_PASS; // 连接数据库密码
$mysql_database = SAE_MYSQL_DB; // 数据库的名字
                              
// 密码（不需要请留空：''）
                              // Password:if don't need,set as ''
$read_pwd = '';
$write_pwd = ''; //注：如果设置了密码，请修改相应payload。
$backdoor_pwd = '';
$color_pwd = ''; //改变网站配色
$install_pwd = '';
$testMySql_pwd = '';

// 网站名称
// Website name
$website_name = 'XSS So ez';

// 开发者信息
// Developer Information
$dev_info = '&copy;2015&nbsp;<a href="https://github.com/Phuker/XSS-So-ez" target="_blank">GitHub</a>';
?>