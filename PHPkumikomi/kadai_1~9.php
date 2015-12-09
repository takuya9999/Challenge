<?php 
// １．2016年1月1日 0時0分0秒のタイムスタンプを作成し、表示してください。
// 　２．現在の日時を「年-月-日 時:分:秒」で表示してください。
// 　３．2016年11月4日 10時0分0秒のタイムスタンプを作成し、
// 　　「年-月-日 時:分:秒」で表示してください。
// 　４．2015年1月1日 0時0分0秒と2015年12月31日 23時59分59秒の差（総秒）
// 　　を表示してください。
// 　５．自分の氏名について、バイト数と文字数を取得して、表示してください。
// 　６．自分のメールアドレスの「@」以降の文字を取得して、表示してください。
// 　７．以下の文章の「I」⇒「い」に、「U」⇒「う」に入れ替える処理を作成し、
// 　　結果を表示してください。
// 　　「きょUはぴIえIちぴIのくみこみかんすUのがくしゅUをしてIます」
// 　８．ファイルに自己紹介を書き出し、保存してください。
// 　９．ファイルから自己紹介を読み出し、表示してください。

date_default_timezone_set('Asia/Tokyo');


	echo "課題１ <br>";
	$kadai1 = mktime(0,0,0,1,1,2016);
	echo "$kadai1 <br>";

	echo "課題２ <br>";
	$kadai2=date("Y年m月d日h時:i分:s秒");
	echo "$kadai2 <br>";

	echo "課題３ <br>";
	$kadai3 =mktime(10,0,0,11,4,2016);
	echo date("Y年m月d日h時:i分:s秒",$kadai3);

	echo "<br>課題４ <br>";
	$kadai4 = mktime(23,59,59,12,31,2015)-mktime(0,0,0,1,1,2015);
	echo "$kadai4 <br>";

	echo "課題５ <br>";
	echo "名前：目黒拓也 <br>";
	echo "バイト数：".strlen("目黒拓也")."<br>";
	echo "文字数：".mb_strlen("目黒拓也")."<br>";


	echo "課題６ <br>";
	echo strstr("mcuuube@gmail.com",'@');
	echo "<br>";


	echo "課題７ <br>";
	echo str_replace(array('I','U'),array('い','う'),'きょUはぴIえIちぴIのくみこみかんすUのがくしゅUをしてIます');
	
	echo "<br>";

	echo "課題８,９ <br>";
	$fp = fopen('kadai8.txt','w');
	fwrite($fp, '目黒拓也です。あびゃ〜〜〜〜〜');
	fclose($fp);
// fcloseしたら変数の中身どうなるのん？
	$fp = fopen('kadai8.txt','r');
	$kadai9 =fgets($fp);
	fclose($fp);
	echo "$kadai9";
	echo "<br>";

	

 ?>