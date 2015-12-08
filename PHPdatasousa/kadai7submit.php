<?php
	//  ７．以下の機能を実装してください。
	
	// 　　　名前・性別・趣味を入力するページを作成してください。
	// 　　　また、入力された名前・性別・趣味を記憶し、次にアクセスした際に
	// 　　　記録されたデータを初期値として表示してください。
	// 　　　
	// 　　　※PHPと同時に、HTMLの知識が必要になります。
	// 　　　※入力フィールドの使い方を調べてみましょう。


$name =$_POST['name'];
$seibetu = $_POST['seibetu'];
$hobby =$_POST['hobby'];
$profile = array("$name","$seibetu","$hobby");
	# code...


// echo "hobby";
setcookie('ProfData',$profile ,1000);
echo "こんにちは！$nameさん！<br>";
echo 'あなたのプロフィールは、 <br>';

foreach ($profile as $key => $value) {
	if ($key==0) {
		echo "名前：";
		# code...
	}

	if ($key==1) {
		echo "性別：";
		# code...
	}

	if ($key==2) {
		echo "趣味：";
		# code...
	}
	echo "$value <br>";
	# code...
}

echo "です!";


	 ?>
