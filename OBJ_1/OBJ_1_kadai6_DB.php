<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>

<?php
// if (isset($_POST['remove_form'])) {
// 	echo "ハローワーク";
// 	# code...
// };

// insert into product_info(productname,price,number) values
// 	('ガリガリ君',60,20);


// 　①ユーザーのログイン・ログアウト機能

// 　　②商品情報登録機能

// 　　③商品一覧機能 




define('DB_DATABASE','Challenge_db');
define('DB_USERNAME','takuya');
define('DB_PASSWORD','9999');
define('PDO_DSN','mysql:dbhost=localhost;dbname='.DB_DATABASE);




try{
$pdo_object = new PDO(PDO_DSN , DB_USERNAME,DB_PASSWORD);
$pdo_object->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$table="product_info";


// ---------------------------------------------------------------

// 製品情報を変更する処理


if(isset($_POST['update_product'])) {
$update_product = $_POST['update_product'];
	

	if($_POST['update_name']) {
	$update_name = $_POST['update_name'];
	$stmt=$pdo_object->prepare("update $table set productname=? where  productID =?");
	$stmt->execute([$update_name,$update_product]);
	}

	if($_POST['update_price']) {
	$update_price = $_POST['update_price'];
	$stmt=$pdo_object->prepare("update $table set price=? where productID = ?");
	$stmt->execute([$update_price,$update_product]);	
	}

	if($_POST['update_number']) {
	$update_number = $_POST['update_number'];
	$stmt=$pdo_object->prepare("update $table set number=?  where productID = ?");
	$stmt->execute([$update_number,$update_product]);
	}


}


// ---------------------------------------------------------------

// if (isset($_POST['test'])) {
// 	echo $_POST['test'];
// 	# submitのnameの変数名で何の値が取れるかテスト。結果はvalueで設定した値が格納される。忘れてたんで確認
// }
// ---------------------------------------------------------------
if(isset($_POST['create_name']) && isset($_POST['create_price']) && isset($_POST['create_number'])){

$create_name=$_POST['create_name'];
$create_price=$_POST['create_price'];
$create_number=$_POST['create_number'];
$stmt = $pdo_object->prepare("insert into product_info(productname,price,number) values
	(:create_name,:create_price,:create_number);");

// $stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':create_name',$create_name, PDO::PARAM_STR);
$stmt->bindValue(':create_price', $create_price, PDO::PARAM_INT);
$stmt->bindValue(':create_number', $create_number, PDO::PARAM_INT);
$stmt->execute();

}

// ---------------------------------------------------------------

// テーブルのヘッダー（フィールド名）を表示させる処理

echo "現在のテーブルは<font color='#FF0000'>".$table."</font>です";


echo '<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">';

$stmt = $pdo_object->query("desc $table");

echo "<tr>";
while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
echo '<th bgcolor="#EE0000" align="right" nowrap><font color="#FFFFFF">'."$row[0]".'</font></th>';
  }
echo "</tr>";

// ---------------------------------------------------------------


// ---------------------------------------------------------------
// テーブルの内容を一覧表示させる処理
// この処理を一番最初に書いてしまうと、商品情報に変更、追加があった場合のmysql実行結果が表示に反映されないので、
// フォームの処理の後に記述する
$stmt = $pdo_object->prepare("select * from $table");

if($stmt->execute()){

$users = $stmt->fetchALL(PDO::FETCH_ASSOC);

foreach($users as $key => $value) {
	echo "<tr>";
	// $users[$key] よりもスマートな指定方法ってあるのん？
	foreach ($users[$key] as $key => $value) {
		echo '<td bgcolor="#99CC00" align="right" nowrap>'."$value".'</td>';
		
	}
		echo "</tr>";
	}
}
	

	echo "</table>";
// ---------------------------------------------------------------




$pdo_object = null;
}catch(PDOException $e){
// エラーメッセージ
echo $e->getMessage();
exit;
}

?>


	
<?php 







 ?>



	<form action="OBJ_1_kadai6_DB.php" method="POST" accept-charset="utf-8">

	<p>
	商品の情報を修正:
	</p>

	<p>
	productID:
	<input type="text" name="update_product" value="" placeholder="">
	</p>
	<p>
	商品名:
	<input type="text" name="update_name" value="" placeholder="">
	値段:
	<input type="text" name="update_price" value="" placeholder="">
	個数:
	<input type="text" name="update_number" value="" placeholder="">
	</p>

	<input type="submit" name="" value="送信">

	</form>	





	<form action="OBJ_1_kadai6_DB.php" method="POST" accept-charset="utf-8">

	<p>
	商品の追加:
	</p>

	<p>
	<p>
	商品名:
	<input type="text" name="create_name" value="" placeholder="">
	値段:
	<input type="text" name="create_price" value="" placeholder="">
	個数:
	<input type="text" name="create_number" value="" placeholder="">
	</p>

	<input type="submit" name="" value="送信">

	</form>

 
</body>
</html>





<!-- コード書く位置で挙動変わるからそこらへん詳しく調べないと -->

<!-- なんか無駄になってアルゴリズム的な。 -->
<!-- foreach($users as $key => $value) {
	$recordkey=$key;

	echo "<tr>";
	foreach ($users[$key] as $key => $value) {
		if ($recordkey==0) {
		echo '<th bgcolor="#EE0000" align="right" nowrap><font color="#FFFFFF">'."$key".'</font></th>';
		}else{
		echo '<td bgcolor="#99CC00" align="right" nowrap>'."$value".'</td>';
		}
	}
		echo "</tr>";
}
	

 -->

 <!-- オートインクリメントのリセットしないとなぁ。なんだっけ？tra...なんとか。
 truncateでした -->
