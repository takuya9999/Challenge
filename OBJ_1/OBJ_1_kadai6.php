<!-- ６．以下の機能を満たすロジックを作成してください。

　　在庫管理システムを作成します。
　　まず、DBにユーザー情報管理テーブルと、商品情報登録テーブルを作成してください。
　　その上で、下記機能を実現してください。

　　①ユーザーのログイン・ログアウト機能

　　②商品情報登録機能

　　③商品一覧機能 -->

<!-- 
user_info
ID
ユーザー名
パスワード


product_info
商品ID
商品名　unique？
値段
種別
個数

create table user_info(
userID int not null auto_increment primary key,
username varchar(255) not null,
pass varchar not null(255)
);

create table product_info(
productID,int not null auto_increment primary key,
productname varchar(255),
price int,
category varchar(255),
number int
)




insert into user_info(userID,username,pass) values
	();


insert into product_info(productID,productname,price,category,number) values
	('開発部');

 -->



<?php 


if (isset($_POST['username']) && isset($_POST['pass'])) {
	$username=$_POST['username'];
	$pass=$_POST['pass'];
}



define('DB_DATABASE','Challenge_db');
define('DB_USERNAME','takuya');
define('DB_PASSWORD','9999');
define('PDO_DSN','mysql:dbhost=localhost;dbname='.DB_DATABASE);

//  function addcol($object ,$table , $col, $type){
//  $object->exec("ALTER TABLE $table ADD $col $type;");
// }
//接続の確立





try{
$pdo_object = new PDO(PDO_DSN , DB_USERNAME,DB_PASSWORD);
$pdo_object->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$pdo_object = null;
}catch(PDOException $e){
// エラーメッセージ
echo $e->getMessage();
exit;
}

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title></title>
 	<link rel="stylesheet" href="">
 </head>
 <body>


	<form action="OBJ_1_kadai6.php" method="POST" accept-charset="utf-8">
	<p>ログイン</p>
	<p>
	ユーザー名：
	<input type="text" name="username" value="" placeholder="">
	</p>
	<p>
	パスワード：
	<input type="text" name="pass" value="" placeholder="">
	</p>	
	<input type="submit" name="" value="送信">
	</form>
 	
 </body>
 </html>