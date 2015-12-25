<?php
define('DB_DATABASE','Challenge_db');
define('DB_USERNAME','takuya');
define('DB_PASSWORD','9999');
define('PDO_DSN','mysql:dbhost=localhost;dbname='.DB_DATABASE);

 function addcol($object ,$table , $col, $type){
 $object->exec("ALTER TABLE $table ADD $col $type;");
}
//接続の確立
//必要な値を渡してPDOオブジェクト(この場合は接続用の通信機のようなもの)を、変数に格納して意する
// $db = new PDO(PDO_DSN , DB_USERNAME,DB_PASSWORD);//PDOオブジェクトの生成
// $pdo_object= new PDO('mysql:host=localhost;dbname=Challenge_db;charset=utf8','hayashi','mypassword');
try{
$pdo_object = new PDO(PDO_DSN , DB_USERNAME,DB_PASSWORD);
$pdo_object->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
// 課題２
// $pdo_object->exec("ALTER TABLE profiles ADD un varchar(255);");
// $pdo_object->exec("ALTER TABLE profiles drop  ;");

// 課題２、レコードを挿入する処理を書く問題だったのん。フィールド追加する問題だと思ってたのん。

// 自分でtellをユニーク設定にしておいて忘れてる奴〜www
// $pdo_object->exec("insert into profiles (name,tell,age,birthday) values
// 	('田中　きなこ','080-5566-7789',24,'2011-12-30');");




// DELETE FROM tbl_name [WHERE where_condition];
	

// $stmt =$pdo_object->prepare("insert into profiles (name,tell,age,birthday) values
// 	(?,?,?,?);");
// $stmt->execute([
// 'もりもりマッチョマン',
// '080-5566-7788',
// 24,
// '2011-12-30'
// 	]);



// insert into profiles(profilesID,name,tell,age,birthday) values
//     (3,'鈴木　実','080-5566-7788',24,'2000-12-24');

// addcol('profiles' ,'address', 'varchar(255)');
// 課題３
$stmt = $pdo_object->prepare("select * from profiles");
// executeは大事なのん！
$stmt->execute();
// fetchだと一行しか取れないのん！全部取りたいときはfetchALLにしないとダメなんなー
// fetchとfetchALLの使い分けについて知りたい
// fetchは英語で（物を）取ってくるという意味らしい。なるほど〜
// exute()した後ってステートメントハンドラに何か値って返ってきてるの？
// っていうか返ってきてるよね・・・何が返ってきてるか検索検索ぅ〜！

//fetchは実行するたびに次の行、次の行って感じで値を返す？らしい。つまり実行するたびに違う値を返す。気が向いたら試してみる。

$users = $stmt->fetchALL(PDO::FETCH_ASSOC);
foreach($users as $key => $value) {
	echo var_dump($value)."<br>";
}

// $users = $stmt->fetchALL(PDO::FETCH_ASSOC);
// foreach($users as $key => $value) {
// 	echo var_dump($value);
// }
// echo "test";

// 課題4

// whereの比較演算子は==じゃなくて= なのかーあびゃあああああ
// 特に理由のないサーバーエラーが襲いかかってくるよ
$stmt = $pdo_object->prepare("select * from profiles where profilesID = :profilesID");
$stmt ->execute([
	':profilesID'=>'1'
	]);

$users = $stmt->fetchALL(PDO::FETCH_ASSOC);
foreach($users as $key => $value) {
	echo var_dump($value)."<br>";
}




// 課題5：nameに「茂」を含む情報を取得し、画面に取得した情報を表示してください

$stmt = $pdo_object->prepare("select * from profiles where name like ?");
$stmt->execute(['%茂%']);


$users = $stmt->fetchALL(PDO::FETCH_ASSOC);
foreach($users as $key => $value) {
	echo var_dump($value)."<br>";
}


// 課題6:課題2でINSERTしたレコードを指定して削除してください。SELECT*で結果を表示してください
// $pdo_object->exec("delete from profiles  where profilesID =6;");


// 課題7:profileID=1のnameを「松岡 修造」に、
// ageを48に、birthdayを1967-11-06に更新してください
$pdo_object->exec("update profiles set name='松岡　修造',age=48,birthday='1967-11-06' where profilesID=1;");
$stmt = $pdo_object->prepare("select * from profiles");
$stmt->execute();


$users = $stmt->fetchALL(PDO::FETCH_ASSOC);
foreach($users as $key => $value) {
	echo var_dump($value)."<br>";
}

// 課題8:検索用のフォームを用意し、名前の部分一致で検索＆表示する処理を構築してください。
// 同じページにリダイレクトするPOST処理と、POSTに値が入っているかの条件分岐を活用すれば、
// 一つの.phpで完了できますので、チャレンジしてみてください









//接続を切断






$pdo_object = null;
}catch(PDOException $e){
// エラーメッセージ
echo $e->getMassege();
exit;
}
