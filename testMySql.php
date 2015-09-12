﻿<?php
    require_once('config.php');

    function test()
    {
        global $mysql_server_name, $mysql_username,$mysql_password;
        $result = "";

        // 连接到数据库
        $conn=mysql_connect($mysql_server_name, $mysql_username,$mysql_password);
        if (!$conn)
        {
            $result = 'Could not connect: ' . mysql_error();
        }
        else
        {
            $result = 'Connect to MySQL succeed!<br />成功连接到数据库！';
            mysql_close($conn);
        }
        return $result;
    }
?>
<!doctype html>
<html>
<head>
    <title>Test MySQL_<?php echo $website_name; ?></title>

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
    <h1>Test MySQL Connection</h1>
    <p><?php
 date_default_timezone_set('Asia/Shanghai');
 echo date('Y-m-d H:i:s'); 
?></p>
    <p><?php echo test(); ?></p>
    <p><?php echo $dev_info;?></p>
</div>
</body>
</html>