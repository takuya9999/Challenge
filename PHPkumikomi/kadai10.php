<?php 

 file_put_contents('kadai10log.txt', date("Y年m月d日h時:i分:s秒")."開始<br>");



// 文字→配列置換

echo "文字を単語ごとに配列にして表示";

$text = 'りんご,ゴリラ,ライオン,';
echo "$text <br>";

$toword =explode(',',$text);

foreach ($toword as $key => $value) {
	echo "$value <br>";
	# code...
}














 file_put_contents('kadai10log.txt', date("Y年m月d日h時:i分:s秒"."終了<br>"),FILE_APPEND);
$file_txt = file_get_contents('kadai10log.txt');
	echo "$file_txt";

 ?>