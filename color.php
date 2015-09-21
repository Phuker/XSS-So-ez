<?php
require_once ('config.php');
if ($color_pwd != '') {
	if (! isset ( $_POST ['pwd'] ) or  $_POST ['pwd'] != $color_pwd) {
		die ( '<!doctype html>
<html>
<head>
<title>修改配色_' . $website_name . '</title>
<meta charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/color.css" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
</head>
<body>
	<div class="select">
		<h1>请输入密码</h1>
			<form action="color.php" method="POST">
			<input type="password" class="cmd" id="input_cmd" name="pwd" value="" autofocus="autofocus" />
			<input type="submit" value="确定" />
		</form>
	</div>
</body>
</html>' );
	}
}
require_once ('db.php');

function filter($str) {
	// 转义为HTML Entity
	$str = trim ( htmlspecialchars ( $str, ENT_QUOTES ) );
	$str = str_replace ( '\\', '&#92;', $str );
	$str = str_replace ( '/', '&#47;', $str );
	return $str;
}
?>
<!doctype html>
<html>
<head>
<title>修改配色_<?php echo $website_name; ?></title>

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
		<form
			action="color.php<?php if(isset($_GET['pwd'])){echo '?pwd='. filter($_GET['pwd']);}?>"
			id="formColor" onsubmit="return checkColor()" method="post">
			<input type="hidden" name="pwd" value="<?php echo filter($_POST ['pwd']);?>">
			<label for="color_black">
				<div style="background-color: #000000" class="showcolor">
					<input type="radio" name="color" id="color_black" value="black" />
				</div> 高端黑
			</label> <label for="color_pink">
				<div style="background-color: #FFAEC9" class="showcolor">
					<input type="radio" name="color" id="color_pink" value="pink" />
				</div> 少女粉
			</label> <label for="color_red">
				<div style="background-color: #CC0000" class="showcolor">
					<input type="radio" name="color" id="color_red" value="red" />
				</div> 姨妈红
			</label> <label for="color_yellow">
				<div style="background-color: #FFCC33" class="showcolor">
					<input type="radio" name="color" id="color_yellow" value="yellow" />
				</div> 咸蛋黄
			</label> <label for="color_green">
				<div style="background-color: #336600" class="showcolor">
					<input type="radio" name="color" id="color_green" value="green" />
				</div> 满眼绿
			</label> <label for="color_blue">
				<div style="background-color: #99D9EA" class="showcolor">
					<input type="radio" name="color" id="color_blue" value="blue" />
				</div> 天空蓝
			</label> <label for="color_purple">
				<div style="background-color: #330033" class="showcolor">
					<input type="radio" name="color" id="color_purple" value="purple" />
				</div> 基佬紫
			</label><br /> <input type="submit" value="确定" />
		</form>
		<?php
		if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
			if (!isset($_POST['color']) or $_POST ['color'] == '') {
				echo '<span class="fail">请选择颜色</span><br />';
			} else {
				// 这样写有点笨，但是省事就这样了
				$css_black = 'body {background-color: #393939;color:#CCCCCC;}div {background-color: #000000;}
		th {background-color: #FF5A09;}span.success {background-color: #003300;}
		span.fail {background-color: #330000;}';
				$css_green = 'body {background-color: #336600;}div {background-color: #99CC33;}
		th {background-color: #FFFF66;}span.success {background-color: #99CC00;}
		span.fail {background-color: #FF6666;}';
				$css_blue = 'body {background-color: #99D9EA;}div {background-color: #FFFFFF;}
		th {background-color: #B5E61D;}span.success {background-color: #B5E61D;}
		span.fail {background-color: #FF8888;}';
				$css_yellow = 'body {background-color: #FFCC33;}div {background-color: #FFFF33;}
		th {background-color: #99CCFF;}span.success {background-color: #66CC00;}
		span.fail {background-color: #FF6666;}';
				$css_pink = 'body {background-color: #FFAEC9;}div {background-color: #FFCCCC;}
		th {background-color: #9933CC;}span.success {background-color: #B5E61D;}
		span.fail {background-color: #FF8888;}';
				$css_red = 'body {background-color: #CC0000;}div {background-color: #FF9999;}
		th {background-color: #66CC00;}span.success {background-color: #66CC00;}
		span.fail {background-color: #FF6666;}';
				$css_purple = 'body {background-color: #330033;}div {background-color: #C0AACC;}
		th {background-color: #AA99FF;}span.success {background-color: #66CC99;}
		span.fail {background-color: #CC33AA;}';
				
				$cmd = '';
				switch ($_POST ['color']) {
					case 'black' :
						$cmd = $css_black;
						break;
					case 'green' :
						$cmd = $css_green;
						break;
					case 'blue' :
						$cmd = $css_blue;
						break;
					case 'pink' :
						$cmd = $css_pink;
						break;
					case 'yellow' :
						$cmd = $css_yellow;
						break;
					case 'red' :
						$cmd = $css_red;
						break;
					case 'purple' :
						$cmd = $css_purple;
						break;
				}
				
				$f = fopen ( "style/color.css", "w" );
				if ($f === false) {
					echo '打开文件失败<br />';
				} else {
					fwrite ( $f, $cmd );
					fclose ( $f );
				}
			}
		}
		?>
		<p>
			<a href="index.php">返回首页</a><br /><?php echo $dev_info;?></p>
	</div>
</body>
</html>