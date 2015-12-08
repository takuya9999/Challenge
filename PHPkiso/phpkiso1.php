<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>phptest</title>
</head>
<body>
	<p>Hello world <?php echo "from PHP"?><p>
	
	<?php 
	echo "課題１ <br>";
	echo "Hello world <br>";


	echo "課題２ <br>";
		$kadai2 = array("groove","-","gear");
	echo "{$kadai2[0]}{$kadai2[1]}{$kadai2[2]}<br>";

	echo "課題３ <br>";
	echo "目黒拓也です。B型。B型どぅえす。<br>";

	echo "課題４,5<br>";
	echo "変数演算 <br>";
	$tasi=5+5;
	$hiki=15-5;
	$kake=2*5;
	$wari=20/2;
	$amari =65%11;

	echo "$tasi <br> ";
	echo "$hiki  <br>";
	echo "$kake  <br>";
	echo "$wari  <br>";
	echo "$amari <br>";


	echo "定数演算 <br>";
    const TASI = 5 + 5;    // 足し算
    const HIKI = 15 - 5;    // 引き算
    const KAKE = 2 * 5;    // 掛け算
    const WARI = 20 / 2;    // 割り算
    const AMARI = 65 % 11;    // 剰余


	echo TASI."<br> ";
	echo HIKI."<br>";
	echo KAKE."<br>";
	echo WARI."<br>";
	echo AMARI."<br>";


	echo "課題６ <br>";
		$kadai6 = array("1","2","a","b");

	for ($i=0; $i <count($kadai6) ; $i++) { 
		if ($kadai6[$i]==1) {
			echo $kadai6[$i]."は1です！<br>";
			# code...
		} elseif ($kadai6[$i]==2) {
			echo $kadai6[$i]."はプログラミングキャンプ！<br>";
			# code...
		}
		elseif ($kadai6[$i]==a) {
			echo $kadai6[$i]."は文字です！<br>";
			# code...
		}else{echo $kadai6[$i]."はその他です！<br>";}


		# code...
	}


	echo "課題７ <br>";
	echo "クエリストリング用メモ↓ <br>";

	echo "?総額=4000&個数=3&商品種別=2 <br>";

	$sougaku = $_GET['総額'];    
    $kosuu = $_GET['個数'];    
    $shouhin = $_GET['商品種別'];    
    $one =round($sougaku/$kosuu);
    $point;
    if ($shouhin==1) {
    	$shouhin ='雑貨';
    }elseif ($shouhin==2) {
    	$shouhin ='生鮮食品';
    	# code...
    }else {
    	$shouhin ='その他';
    }
    if ($sougaku >=5000) {
    	$point =$sougaku*0.05;
    	# code...
    } elseif ($sougaku >=3000) {
    	$point =$sougaku*0.04;

    	# code...
    }
    echo "商品種別:$shouhin,総額:$sougaku,１個あたり:$one,ポイント:$point";
    

	 ?>
<!-- 
	 四則演算 $hoge++ ++$hogeの違い
	 連結の記述の仕方 -->
</body>
</html>