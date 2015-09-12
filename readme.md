#XSS So easy
##简介
此网站用于XSS Cookie 劫持攻击中接收Cookie
花了半天写出来，简单美化一下，不知道外观如何
适用于 PHP MySQL

##使用方法
配置config.php，填写数据库用户名、密码等信息。
install.php：创建数据库、表等操作
write.php：GET或者POST得到的Cookie。例如：write.php?domain=FOO&url=BAR&cookie=ABC%3dabc
数据库需要提交的字段为：domain（长度小于50）、url、cookie

##附加功能
读、写密码
自定义网站名称（title和页面中显示）
自定义开发者信息（底部显示）

##TODO
目前read.php只能一次输出所有。必要时加上条件查找。
SAE提醒，mysql_connect()函数以后会被抛弃。考虑改写成新版函数。