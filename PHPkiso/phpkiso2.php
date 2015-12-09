<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<?php 

echo "課題１ <br>";

	$kadai1 =3;
	$kadai2 ='あ';

switch ($kadai1) {
	case '1':
	echo "one";
		
		break;

	case '2':
	echo "two";
		
		break;

	default:
	echo '想定外';
		
		break;
}
	echo "<br>";


echo "課題２ <br>";

switch ($kadai2) {
	case 'A':
	echo "英語";
		break;

	case 'あ':
	echo "日本語";
		break;
// caseに当てはまらない時、なにも返す必要がない時はdefault省略可
	// default:
	// echo '';
	// 	break;
}

echo "<br>";
echo "課題３<br>";


$kadai3=1;

for ($i=0; $i < 20; $i++) { 
	$kadai3 *=8;
	
}
echo "$kadai3<br>";

echo "課題４ <br>";


$kadai4;
for ($i=0; $i < 30; $i++) { 
	$kadai4 =$kadai4.'A';
	
}
echo "$kadai4<br>";


echo "課題５ <br>";
$kadai5;
for ($i=0; $i <=100 ; $i++) { 
	$kadai5+=$i;
	
}

echo "$kadai5<br>";

echo "課題６ <br>";

$kadai6=1000;

while ( $kadai6>= 100) {
	$kadai6=$kadai6/2;
}
echo "$kadai6<br>";


echo "課題７ <br>";

$kadai7 = array(10, 100, 'soeda', 'hayashi', -20, 118, 'END');
var_dump($kadai7);


echo "<br> 課題８ <br>";
$kadai7[2]=33;
var_dump($kadai7);



echo "<br> 課題９ <br>";
 $kadai9 = array(1 => 'AAA', 'hello' => 'world','soeda' =>33 ,20 =>20 );
var_dump($kadai9);

echo "<br> 課題１０ <br>";

echo "素因数分解クエリストリング用↓ <br>";
echo "?元の値= <br>" ;

 $sosuu =array(2, 3, 5, 7);
 $kadai10= $_GET['元の値']; 

echo "<br>$kadai10<br>";
while($kadai10 >1){

 for ($i=0; $i < count($sosuu); $i++) { 
 	if($kadai10%$sosuu[$i] ==0){
 		$kadai10=$kadai10/$sosuu[$i];
 		echo "$sosuu[$i],";
 		break;
 	}

 	if ($i==3) {
 		$kadai10=0;
 		echo "その他";
 	}
 	
 }

}

 ?>


</body>
</html>

