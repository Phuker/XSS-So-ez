<?php
require_once ('config.php');
require_once('func.inc.php');
handlePwd($COLOR_PWD);

$colorConfig = json_decode(file_get_contents('./style/colors/config.json'), True);
?>
<!doctype html>
<html>
<head>
<title>修改配色_<?php echo $WEBSITE_NAME; ?></title>

<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<link rel="stylesheet" type="text/css"
	href="style/color.css<?php echo '?time='. time();?>" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
</head>

<body>
	<div>
		<h1>修改网站配色</h1>
		<p>请点击颜色块或文字选择颜色。此操作需要color.css有写权限。</p>
		<script type="text/javascript">
		function checkColor(){
			var f = document.getElementById('formColor');
			if(f.color.value == ''){
				alert('请选择颜色！\nPlease select a color!');
				return false;
			}
			else{
				return true;
			}
		}
		</script>
		<form action="" id="formColor" onsubmit="return checkColor()" method="post">
			<input type="hidden" name="pwd" value="<?php echo filter(@$_POST ['pwd']);?>">
			<?php
			foreach ($colorConfig as $color) {
				echo "<label for=\"color_{$color['name']}\">
				<div style=\"background-color: {$color['color']}\" class=\"showcolor\">
					<input type=\"radio\" name=\"color\" id=\"color_{$color['name']}\" value=\"{$color['name']}\" />
				</div> {$color['nameZh']}
			</label>\n";
			}
			?>
			<br /> <input type="submit" value="确定" />
		</form>
		<?php
		if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
			if (!isset($_POST['color']) or $_POST ['color'] == '') {
				echo '<span class="fail">请选择颜色</span><br />';
			} else {
				foreach ($colorConfig as $color) {
					if ($_POST['color'] === $color['name']){
						$css = file_get_contents('./style/colors/' . $color['file']);
						$f = fopen ( "style/color.css", "w" );
						if ($f === false) {
							echo '打开文件失败<br />';
						} else {
							fwrite ( $f, $css );
							fclose ( $f );
						}
					}
				}	
			}
		}
		?>
		<p>
			<a href="index.php">返回首页</a><br /><?php echo $DEV_INFO;?></p>
	</div>
</body>
</html>