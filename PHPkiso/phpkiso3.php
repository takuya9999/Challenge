<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>phpkiso3</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<?php 

	echo "課題１ <br>";
	// function にpublic入れるとダメやん・・・
	 function prof()
	{
		echo "目黒拓也<br>";
		echo "４月２２日<br>";
		echo "趣味はゲーム制作どぅえす<br>";
		return true;
	}

	prof();
	prof();


	echo "課題２ <br>";
	function oddeven($value)
	{
		if($value%2==1){
			echo "奇数";
		}else{
			echo "偶数";
		}
	}
	oddeven(2);
	echo "<br>";


	echo "課題３ <br>";
	function kadai3($i ,$value='5',$type=false)
	{
		if ($type===false) {
		echo $i*$value."<br>";
			# code...
		}else{
		echo ($i*$value)**$type."<br>";
		}
	}
	kadai3(3);


	echo "課題４ <br>";
	// if文の条件式で関数使うと関数が実行されるぽい？
	if (prof()) {
		echo "この処理は正しく実行できました<br>";
		# code...
	}else{
		echo "正しく実行できませんでした<br>";
	}


	echo "課題５ <br>";
function kadai5()
	{
		return $variable=array(
		 "id:15<br>",
		 "名前：五郎丸<br>",
		 "生年月日：三月一日<br>",
		 "住所：福岡県福岡市<br>"
		 );
	}

	foreach (kadai5() as $key => $value) {
		if ($key==0) {
			continue;
		}
		echo "$value";
	}
	// returnの戻り値の変数のグローバルでの扱いについてちゃんと理解する
	var_dump($variable);
	echo "<br>";
	var_dump(kadai5());
	echo "<br>";

	echo "課題６ <br>";
function kadai6($id)
	{
		if ($id==1) {
		return $user1=array(
		 "id:1<br>",
		 "名前：五郎丸<br>",
		 "生年月日：3月1日<br>",
		 "住所：福岡県福岡市<br>"
		 );
			# code...
		}
		elseif ($id==2) {
		return $user2=array(
		 "id:2<br>",
		 "名前：太郎丸<br>",
		 "生年月日：6月3日<br>",
		 "住所：横浜<br>"
		 );
	}

		elseif ($id==3) {
		return $user3=array(
		 "id:3<br>",
		 "名前：ジローラモ<br>",
		 "生年月日：9月6日<br>",
		 "住所：イタリア<br>"
		 );
		}

		else{
		return $user4=array(
		 "id:null<br>",
		 "無効な値が入力されています<br>"
		 );
	}


	}

	foreach (kadai6(2) as $key => $value) {
		if ($key==0) {
			continue;
		}
		echo "$value";
	}

$three =3;

	echo "課題７ <br>";
	function kadai7()
	{
		static $count; //式は代入できないんですう〜
		global $three; //式は代入できないんですう〜
		++$count;
		$three*=2;
		echo "カウント：".$count."<br>値：".$three."<br>";
	}

	for($i=0; $i <20; $i++) {
	kadai7(); 
		# code...
	}

// phpにおける変数のリファレンスについてちゃんと理解する　
	// http://php.net/manual/ja/control-structures.foreach.php
	// breakの位置
	
 ?>
</body>
</html>