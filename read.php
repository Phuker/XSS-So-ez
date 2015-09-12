﻿<?php
require_once('config.php');
require_once('db.php');
if($read_pwd!='' && $_GET['pwd']!=$read_pwd)
{
  die('Who are you? Password requierd.');
}
?>
<!doctype html>
<html>
<head>
    <title>读取数据库_<?php echo $website_name; ?></title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <style type="text/css">
    body {
        background-color: #99D9EA;
        margin: 0;
        padding: 0;
    }
    div {
    	background-color: #fff;
	    padding: 20px 30px 20px 30px;
	    margin: 1em 0.5em 1em 0.5em;
	    border-radius: 1em;
	    min-height: 75%; /*数据不足撑起页面*/
    }
    a:link, a:visited {
        color: #38488f;
        text-decoration: none;
    }
    /*吐槽：搞这个表格真是费劲。今天学习不少CSS，还加了一个switch...case...，坑爹。*/
    th {
    	word-break: normal; /*表头不换行*/
	}
	td {
	    border-style: solid;
	    border-width: 1px;
	}
	table {
	    border-style: solid;
	    border-width: 1px;
	    word-wrap:break-word;
	    min-width:100%;
	}
    </style>
</head>

<body>
<div>
<h1>数据库内容</h1>
<?php
    require_once('config.php');
    require_once('db.php');


      // 从表中提取信息的sql语句
      $sql="SELECT * FROM `info`";
      // 执行sql查询
      $result=mysql_query($sql);
      // 获取查询结果
      $row=mysql_fetch_row($result);
      
      echo '<table>';

      // 显示字段名称
      echo '<tr bgcolor="#B5E61D">';
      for ($i=0; $i<mysql_num_fields($result); $i++)
      {
        echo '<th><b>'.
        mysql_field_name($result, $i);
        echo "</b></th>";
      }
      echo "</tr>";


      $count = 0;
      // 定位到第一条记录
      mysql_data_seek($result, 0);
      // 循环取出记录
      while ($row=mysql_fetch_row($result))
      {
        $count++;
        echo "<tr>";
        for ($i=0; $i<mysql_num_fields($result); $i++ )
        {
        	switch ($i){
        		case 0: //id
        			echo '<td style="word-break: keep-all;">';
        			break;
        		case 1: //time
        			echo '<td style="word-break: keep-all;">';
        			break;
        		case 2: // domain
        			echo '<td style="word-break: keep-all;">';
        			break;
        		default:
        			echo '<td style="word-break: break-all;">';
        			break;
        	}
          echo $row[$i];
          echo '</td>';
        }
        echo "</tr>";
      }
     
      echo "</table>";
      echo '共查询到 '.$count.' 条记录';
      // 释放资源
      mysql_free_result($result);
      // 关闭连接（并不必需，因为脚本执行完毕会自动关闭）
      mysql_close($conn);
?>
<?php echo '<p>'.$dev_info.'</p>';?>
</div>
</body>
</html>