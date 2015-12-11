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



// 課題3:引き数が3つの関数を定義する。
// 1つ目は適当な数値を、2つ目はデフォルト値が5の数値を、
// 最後はデフォルト値がfalseの$typeを引き数として定義する。
// 1つ目の引き数に2つ目の引き数を掛ける計算をする関数を作成し、
// $typeがfalseの時はその値を表示、trueのときはさらに累乗して表示する。


// 私の課題に対する解釈に誤りがあったようなので、私がどういう意図でこの定義関数を作成したかについて解説します。
// 私はこの課題３を、kadai(3),のように引数が一つだけの場合はデフォルトで指定した二番目の引数と
// 掛けた結果を返し、引数が二つの場合は、その二つの数字を掛け合わせた数を返し、
// 引数が三つの場合は三つ目に指定した数で累乗を行う定義関数を作成する課題と受け取り、課題に取り組みました。
//実行結果は私の意図した通りの値を返していると思います。
// **はphp5.6以降から使用可能になった累乗の演算子です。計算結果は以下の通りです。
//どうやら私の解釈が間違っているようで、課題の意図を正しく把握できていません。
// お手数をおかけしますが、ご教示お願いいたします。	

	echo "課題３ <br>";
	function kadai3($i ,$value='5',$type=false)
	{
		if ($type===false) {
		echo $i*$value."<br>";
			# code...
		}else{
			// ここ構文チェックするとエラー出るけど間違ってるのん？	
		echo ($i*$value)**$type."<br>";
		}
	}
	echo 'kadai3(3);';
	kadai3(3);
	echo 'kadai3(3,2);';
	kadai3(3,2);
	echo 'kadai3(3,2,2);';
	kadai3(3,2,2);



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