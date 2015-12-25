<?php 


//定数の設定
define('DB_DATABASE','Challenge_db');
define('DB_USERNAME','takuya');
define('DB_PASSWORD','9999');
define('PDO_DSN','mysql:dbhost=localhost;dbname='.DB_DATABASE);

/**
* 
*/
class User
{
	// public $id;
	// public $name;
	// public $age;
	public function show()
	{
		echo "$this->name($this->age)";
		# code...
	}
}



	try{
		//接続
		$db = new PDO(PDO_DSN , DB_USERNAME,DB_PASSWORD);//PDOオブジェクトの生成
		//エラのー設定
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


		/*
		(1) exec(): 結果を返さない、安全なSQL
		(2) query():結果を返す、安全、何回も実行されないSQL
		(3) prepare():結果を返す、安全対策が必要、複数回実行されるSQL キャッシュが残るので複数回実行するときに高速

		*/
		// ステートメントオブジェクトが返ってくるので$stmtに代入
		// $stmt = $db->prepare("insert into user2 (name , age) values (?,?)");
		// ステートメントオブジェクトのexecute関数で配列を渡すと安全な形でvaluesの値を渡せる
		// $stmt->execute(['目黒拓也',26]);
		// 最後に挿入されたレコードのIDを取得する
		// IDって自分で設定していなくても勝手に設定されているものなのですか？
		// echo "inserted:" .$db->lastInsertId();


		// valuesの値は??じゃなくて名前を入力することもできる

		// $stmt = $db->prepare("insert into user2 (name , age) values (:name,:age)");
		// $stmt->execute([':name'=>'目黒拓也',':age'=>26]);
		// echo "inserted:" .$db->lastInsertId();



		// insert

		// $db->exec("insert into user2 (name, age) values ('目黒',26)");
		// echo "user added!";

		// bindは縛るとか、くくるっていう意味らしい。つまり、そういうことらしい。

		// select all 
		// $stmt = $db->query("select * from user2");

		// $stmt = $db->prepare("select age from user2 where age > ?");
		// $stmt->execute([20]);


		// $stmt = $db->prepare("select name from user2 where name like ?");
		// $stmt->execute(['%t%']);



		// 関数名の大文字、小文字の区別があるのかないのか、どっちなんだい！！
		// 条件付き抽出


		// $stmt = $db->prepare("select age from user2 order by score desc limit ?");
		// $stmt->bindValue(1,1, PDO::PARAM_INT);
		// $stmt->execute();



		// FETCH_CLASS
		// $stmt = $db->query("select * from user2");
		// $users = $stmt->fetchALL(PDO::FETCH_CLASS,'User');
		// foreach ($users as $user) {
		// 	$user->show();
		// }







		// 表示



		// $users = $stmt->fetchALL(PDO::FETCH_ASSOC);
		// foreach ($users as $user) {
		// 	var_dump($user);
		// }
		// echo $stmt->rowCount(). "records found.";


		// update
		$stmt = $db->prepare("update user2 set age = :age where name =:name");
		$stmt->execute([
			':age'=>100,
			':name'=>'taguchi'
			]);

		echo "row updated:" . $stmt->rowCount();



		// delete
		$stmt = $db->prepare("delete from user2 where name =:name");
		$stmt->execute([
			':name'=>'taguchi'
			]);

		echo "row deleted:" . $stmt->rowCount();



		// transaction:ある一連の処理が実行されるのを保証するための仕組み

		$db->beginTransaction();
		$db->exec("update user2 set age = age - 10 where name ='taguchi' ");
		$db->exec("update user2 set age = age + 10 where name ='fcouji' ");
		$db->commit();

		//接続解除
		$db=null;



	}catch(PDOException $e){
		// トランザクションのエラー処理
		$db->rollBack();
		
		
		echo $e->getMessage(); //getMeesage()が補完されないけどなんでや
		exit;
	}


 ?>