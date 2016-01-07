<?php 
// <?php の前に行が入ってるとheader関数がエラーになるみたい


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





if(isset($_POST['username']) && isset($_POST['pass']) ){
$username =$_POST['username'];
$pass =$_POST['pass'];
$stmt = $pdo_object->prepare("select * from user_info where username = :username and pass = :pass");
$stmt->execute([":username"=>$username,":pass"=>$pass]);
$user = $stmt->fetchALL(PDO::FETCH_ASSOC);
// var_dump($user);
if ($user) {
	header("Location: OBJ_1_kadai6_DB.php");
}else{
	header("Location: OBJ_1_kadai6.php");

}

}





$pdo_object = null;
}catch(PDOException $e){
// エラーメッセージ
echo $e->getMessage();
exit;
}

 ?>
