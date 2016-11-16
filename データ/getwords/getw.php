<?php
//预处理
if (!isset($_POST['submit'])) {
	header('location:index.html');
}
$urls=explode("\r\n", $_POST['urls']);
// print_r($urls);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>结果</title>
	<?php
	//新方法直接获取并匹配
	function getWords($urls){
		echo '<dl>';
		foreach ($urls as $key => $url) {
			$words=file_get_contents($url);
			$words=iconv('shift-jis', "utf-8", $words);
			preg_match_all('/<li><a href="\.\.\/w\/.*?>(.*?)<\/a>/',$words, $matches);
			$matchesNum=count($matches[1]);
			echo "<ol><dt><b>{$url}-{$matchesNum}</b></dt>";
			if ($matches[1]) {
				for ($i=0; $i <$matchesNum ; $i++) { 
					echo "<dd><li>{$matches[1][$i]}</li></dd>";
				}
				echo '</ol>';
			}else{
				echo '<dd>没有数据</dd></dl></ol>';
			}
		}
		echo '</dl>';
	}
	//老方法匹配数据
	function matchW(){
		$f=fopen('w.txt', 'r');
		$w=fread($f, filesize('w.txt'));
		fclose($f);
		preg_match_all('/<li><a href="\.\.\/w\/.*?>(.*?)<\/a>/',$w, $matches);
		$f=fopen('wm.txt', 'w');
		fwrite($f, implode("\r\n", $matches[1]));
		fclose($f);
	}
	//老方法获取数据源
	function getW(){
		$w=file_get_contents("http://e-words.jp/p/t-PC.html");
		$w=iconv('shift-jis', "utf-8", $w);
		$f=fopen('w.txt', 'w+');
		fwrite($f, $w);
		fclose($f);
	}
	?>
</head>
<body>
<?php
getWords($urls);
?>
</body>
</html>