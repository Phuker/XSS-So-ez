<?php
function filter($str) {
	// 转义为HTML Entity
	$str = trim ( htmlspecialchars ( $str, ENT_QUOTES ) );
	$str = str_replace ( '\\', '&#92;', $str );
	$str = str_replace ( '/', '&#47;', $str );
	return $str;
}

function handlePwd($pwd){
	if ($pwd != '') {
		if (! isset ( $_POST ['pwd'] ) or  $_POST ['pwd'] !== $pwd) {
			require('./pwd_form.inc.php');
			die ();
		}
	}
}

function showTable($result) {
	if(empty($result)){
		echo '数据为空';
	} else{
		$rowCount = sizeof($result);
		echo "<p style=\"margin:0;\">总计 $rowCount</p>\n";
		echo '<table style="margin:0;"><tr>';
		foreach ($result[0] as $key => $value) {
			echo "<th>$key</th>";
		}
		echo '</tr>';
		foreach ($result as $key => $row) {
			echo "<tr>\n";
			foreach ($row as $keyOfRow => $cell) {
				echo '<td>' . filter($cell) . '</td>';
			}
			echo "</tr>\n";
		}
		echo '</table>';
		echo "<p style=\"margin:0;\">总计 $rowCount</p>\n";
	}
}

// xss_data表专用
function showTableXSSData($result) { 
	if(empty($result)){
		echo '数据为空';
	} else{
		$rowCount = sizeof($result);
		echo "<p style=\"margin:0;\">总计 $rowCount</p>\n";
		echo '<table style="margin:0;"><tr>';
		foreach ($result[0] as $key => $value) {
			echo "<th>$key</th>";
		}
		echo "<th>操作</th></tr>\n";
		echo '</tr>';
		foreach ($result as $key => $row) {
			echo "<tr>\n";
			foreach ($row as $keyOfRow => $cell) {
				switch ($keyOfRow) {
					case 'id':
					case 'time':
					case 'domain':
						echo '<td class="kn">';
						break;
					case 'location':
					case 'toplocation':
					case 'cookie':
					case 'opener':
						echo '<td class="bs">';
						break;
					default:
						echo '<td>';
						break;
				}
				echo filter($cell) . '</td>';
			}
			echo '<td class="kn"><button type="submit" value="'.$row['id'].'" name="delete">删除</button></td>'."\n";
			echo "</tr>\n";
		}
		echo '</table>';
		echo "<p style=\"margin:0;\">总计 $rowCount</p>\n";
	}
}