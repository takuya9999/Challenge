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




if(isset($_POST['multiNamesearch'])) {
$multiNamesearch =$_POST['multiNamesearch'];
	# code...
}



if(isset($_POST['multiAgesearch'])) {
$multiAgesearch =$_POST['multiAgesearch'];
	# code...
}



if(isset($_POST['multiBirthserch'])) {
$multiBirthserch =$_POST['multiBirthserch'];
	# code...
}

// $seibetu = $_POST['removeID'];
// $update_prof=$_POST['update_prof'];
// $update_name=$_POST['update_name'];
// $update_tell=$_POST['update_tell'];
// $update_age=$_POST['update_age'];
// $update_birthday=$_POST['update_birthday'];
// $multiNamesearch =$_POST['multiNamesearch'];
// $multiAgesearch =$_POST['multiAgesearch'];
// $multiBirthserch =$_POST['multiBirthserch'];





// $profile = array("$name","$seibetu","$hobby");




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
// session_start();
$_SESSION['table']="profiles";
$tableList = array();
$table="profiles";

$stmt = $pdo_object->query("show tables");
// $tables = $stmt->fetchALL(PDO::FETCH_ASSOC);

echo "<p>テーブル一覧</p>";

// このwhile文の条件式の書き方よーわからん。代入が成功したらってことかな？
// 参考：↓
// http://stackoverflow.com/questions/16213695/pdo-show-tables-array
  while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $tableList[] = $row[0];
		echo 
		"<form action=".'"DBfromPHPkadai8.php" method="POST" accept-charset="utf-8">'.
	'<p>
	<input type="submit" name='.'"'."table".'"' .'value='.'"'.$row[0].'"'.">".
	"</p>	
	</form>";
       
    }




 // print_r($tableList);

// foreach ($tables as $key => $value) {	
// 		echo "$tables[$key]";
// 		}


if (isset($_POST['table'])) {
	// $table=$_POST['table'];
	// $table=$_POST['table'];
$_SESSION['table']=$_POST['table'];
$table=$_SESSION['table'];

	echo "現在のテーブルは<font color='#FF0000'>".$table."</font>です";





echo '<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">';

$stmt = $pdo_object->prepare("select * from $table");

if($stmt->execute()){

$users = $stmt->fetchALL(PDO::FETCH_ASSOC);

	if (count($users)>0) {

	echo "<tr>";
	foreach ($users[0] as $key => $value) {
	
		echo '<th bgcolor="#EE0000" align="right" nowrap><font color="#FFFFFF">'."$key".'</font></th>';
		}

		echo "</tr>";


foreach($users as $key => $value) {
	echo "<tr>";
	// $users[$key] よりもスマートな指定方法ってあるのん？
	foreach ($users[$key] as $key => $value) {
		echo '<td bgcolor="#99CC00" align="right" nowrap>'."$value".'</td>';
		
	}
		echo "</tr>";
	}
}
	
}
	echo "</table>";




}



if(isset($_POST['DBview'])) {


// 	echo '<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">';

// $stmt = $pdo_object->prepare("select * from $table");
// $stmt->execute();
// $users = $stmt->fetchALL(PDO::FETCH_ASSOC);


// 	echo "<tr>";
// 	foreach ($users[0] as $key => $value) {
	
// 		echo '<th bgcolor="#EE0000" align="right" nowrap><font color="#FFFFFF">'."$key".'</font></th>';
// 		}

// 		echo "</tr>";


// foreach($users as $key => $value) {
// 	echo "<tr>";
// 	// $users[$key] よりもスマートな指定方法ってあるのん？
// 	foreach ($users[$key] as $key => $value) {
// 		echo '<td bgcolor="#99CC00" align="right" nowrap>'."$value".'</td>';
		
// 	}
// 		echo "</tr>";
// }
	

// 	echo "</table>";
// 	echo "<p>$table</p>";



}



if (isset($_POST['TBcreate'])) {
	if (!empty($_POST['TB_name'])) {
		$TB_name=$_POST['TB_name'];
		$stmt = $pdo_object->query("CREATE TABLE $TB_name ");

	}

	# code...
}if (isset($_POST['TBdrop'])) {
	if (!empty($_POST['TB_name'])) {
		$TB_name=$_POST['TB_name'];
		$stmt = $pdo_object->query("TRUNCATE TABLE $TB_name ");

	}

	# code...
}


if(isset($_POST['namesearch'])) {
$namesearch =$_POST['namesearch'];

echo '<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
<tr>
<th bgcolor="#EE0000"><font color="#FFFFFF">profilesID</font></th>
<th bgcolor="#EE0000" width="150"><font color="#FFFFFF">name</font></th>
<th bgcolor="#EE0000" width="200"><font color="#FFFFFF">tell</font></th>
<th bgcolor="#EE0000" width="200"><font color="#FFFFFF">age</font></th>
<th bgcolor="#EE0000" width="200"><font color="#FFFFFF">birthday</font></th>
</tr>';

$stmt = $pdo_object->prepare("select * from $table where name like ?");
$stmt->execute(["%$namesearch%"]);
$users = $stmt->fetchALL(PDO::FETCH_ASSOC);
foreach($users as $key => $value) {
	echo "<tr>";
	foreach ($users[$key] as $key => $value) {
		echo '<td bgcolor="#99CC00" align="right" nowrap>'."$value".'</td>';
		
	}
		echo "</tr>";
}
	

	echo "</table>";
}





if(isset($_POST['removeID'])) {
$removeID = $_POST['removeID'];
	

$stmt = $pdo_object->prepare("delete from $table where profileID = ? ");
$stmt->execute(["%$profilesID%"]);
$users = $stmt->fetchALL(PDO::FETCH_ASSOC);
	# code...

}


if(isset($_POST['TBdrop'])) {
$removetb = $_POST['TB_name'];
$pdo_object->query("DELETE FROM $removetb");

}




// issetとtrue,faulseの違いがわかってない。
// issetでupdate_nameを書いたらレコードのすべての値が0で上書きされてしまった。原因はよく分からない。

if(isset($_POST['update_prof'])) {
$update_prof = $_POST['update_prof'];
	

	if($_POST['update_name']) {
	$update_name = $_POST['update_name'];
	$stmt=$pdo_object->prepare("update $table set name=? where  profilesID =?");
	$stmt->execute([$update_name,$update_prof]);
	}

	if($_POST['update_tell']) {
	$update_tell = $_POST['update_tell'];
	$stmt=$pdo_object->prepare("update $table set tell=? where profilesID = ?");
	$stmt->execute([$update_tell,$update_prof]);	
	}

	if($_POST['update_age']) {
	$update_age = $_POST['update_age'];
	$stmt=$pdo_object->prepare("update $table set age=?  where profilesID = ?");
	$stmt->execute([$update_age,$update_prof]);
	}

	if($_POST['update_birthday']) {
	$update_birthday = $_POST['update_birthday'];
	$stmt=$pdo_object->prepare("update $table set birthday=?  where profilesID =? ");
	$stmt->execute([$update_birthday,$update_prof]);
	}

	// いやー、これまとめてガッと行きたいよね。なんだこのちょうあなろぐコード
	// $stmt=$pdo_object->prepare("update $table set name='update_name',tell=update_tell,age=update_age,birthday=update_birthday where profilesID=update_prof;");
	// $stmt->execute();



}



//------------------------------------------------------------------------------------------------


if(isset($_POST['multisearch'])){

	$searchSQL = "select * from $table where " ;
	$serachcount=0;
	$searchexecute=array();

	// $multiNamesearch;
	// $multiAgesearch;
	// $multiBirthsearch;

	if($_POST['multiNamesearch']) {
		if ($serachcount >=1) {
			$searchSQL=$searchSQL." and ";
			// $searchexecute=$searchexecute.",";
		}
		$multiNamesearch =$_POST['multiNamesearch'];
		$searchSQL = $searchSQL."name like :name";
		// $searchexecute=$searchexecute.'":name"=>"%$multiNamesearch%"';
		$searchexecute +=array(":name"=>'%'.$multiNamesearch.'%');
		
		$serachcount++;	
	}


	if($_POST['multiAgesearch']) {
	
		if($serachcount >=1) {
			$searchSQL=$searchSQL." and ";
			// $searchexecute=$searchexecute.",";
		}

		$multiAgesearch = $_POST['multiAgesearch'];
		var_dump($_POST);
		$searchSQL = $searchSQL."(age = :age)";
		// $searchexecute=$searchexecute.'":age"=>"$multiAgesearch"';
		$searchexecute +=array(":age"=>$multiAgesearch);

		$serachcount++;	

	}



	if($_POST['multiBirthsearch']) {
		if ($serachcount >=1) {
			$searchSQL=$searchSQL." and ";
			// $searchexecute=$searchexecute.",";
		}
		$multiBirthsearch = $_POST['multiBirthsearch'];
		$searchSQL = $searchSQL."birthday like :birthday";
		// $searchexecute=$searchexecute.'":birthday"=>"%$multiBirthsearch"';
		$searchexecute +=array(":birthday"=>'%'.$multiBirthsearch);

		$serachcount++;	

	}







echo '<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">';

echo $searchSQL;
// echo "<br>";
// echo "$searchexecute";

var_dump([$searchexecute]);

$stmt=$pdo_object->prepare($searchSQL);
if($stmt->execute($searchexecute)){

$users = $stmt->fetchALL(PDO::FETCH_ASSOC);


	echo "<tr>";
	if (count($users)>0) {

	foreach ($users[0] as $key => $value) {
	
		echo '<th bgcolor="#EE0000" align="right" nowrap><font color="#FFFFFF">'."$key".'</font></th>';
		}

		echo "</tr>";



foreach($users as $key => $value) {
	echo "<tr>";
	// $users[$key] よりもスマートな指定方法ってあるのん？
	foreach ($users[$key] as $key => $value) {
		echo '<td bgcolor="#99CC00" align="right" nowrap>'."$value".'</td>';
		
	}

}
		# code...
	}
		echo "</tr>";

	}
	echo "</table>";


}

//----------------------------------------------------------------------------------------



// if (($multiAgesearch==true) or ($multiBirthserch=true) or ($multiNamesearch=true)) {
	
// $stmt=$pdo_object->prepare("select * from $table where name like :name  and (age = :age) and (birthday = :birthday)");
// $stmt->execute([':name'=>"%$multiNamesearch%",':age'=>"$multiAgesearch",'birthday'=>"$multiBirthserch"]);

// 	# code...
// }

// 	# code...
// }

//接続を切断

$pdo_object = null;
}catch(PDOException $e){
// エラーメッセージ
echo $e->getMessage();
exit;
}

?>




<!-- <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>

 -->
	
<?php 


// if (isset($_POST['remove_form'])) {
// 	echo "ハローワーク";	
// }else{
// 	echo "ハーン！";
// }







 ?>
<!-- <table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
<tr>
<th bgcolor="#EE0000"><font color="#FFFFFF">メニュー</font></th>
<th bgcolor="#EE0000" width="150"><font color="#FFFFFF">説明</font></th>
<th bgcolor="#EE0000" width="200"><font color="#FFFFFF">豆知識</font></th>
</tr>
<tr>
<td bgcolor="#99CC00" align="right" nowrap>カルボナーラ</td>
<td bgcolor="#FFFFFF" valign="top" width="150">玉子とベーコンとクリームソースのパスタ</td>
<td bgcolor="#FFFFFF" valign="top" width="200">カルボナーラとは炭焼き職人という意味</td>
</tr>
<tr>
<td bgcolor="#99CC00" align="right" nowrap>ペスカトーレ</td>
<td bgcolor="#FFFFFF" valign="top" width="150">エビとあさりの漁師風パスタ</td>
	</tr>
	</table> -->



<!-- <form action="DBfromPHPkadai8.php" method="POST" accept-charset="utf-8">
	<p>
	<input type="submit" name="tableview" value="現在のDBの表示">
	</p>	
	</form>

 -->

	<form action="DBfromPHPkadai8.php" method="POST" accept-charset="utf-8">
	<p>
	<input type="text" name="TB_name" value="" placeholder="テーブル名">
	<input type="submit" name="TBcreate" value="テーブルの作成">
	</p>	
	</form>



	<form action="DBfromPHPkadai8.php" method="POST" accept-charset="utf-8">
	<p>
	<input type="text" name="TB_name" value="" placeholder="">
	<input type="submit" name="TBdrop" value="テーブルの削除">
	</p>	
	</form>

<!-- 
	<form action="DBfromPHPkadai8.php" method="POST" accept-charset="utf-8">
	<p>
	<input type="submit" name="DBview" value="現在のテーブルの表示">
	</p>	
	</form> -->



	<form action="DBfromPHPkadai8.php" method="POST" accept-charset="utf-8">
	<p>
	名前の部分一致検索、表示：
	<input type="text" name="namesearch" value="" placeholder="">
	</p>	
	<input type="submit" name="" value="送信">
	</form>






	<form action="DBfromPHPkadai8.php" method="POST" accept-charset="utf-8" name="remove_form">

	<p>
	profileIDで指定したレコードを削除できるフォーム：
	<input type="text" name="removeID" value="" placeholder="">
	</p>

	<input type="submit" name="" value="送信">

	</form>





	<form action="DBfromPHPkadai8.php" method="POST" accept-charset="utf-8">

	<p>
	profileIDで指定したレコードの、profileID以外の要素をすべて上書きできるフォーム:
	</p>

	<p>
	profileID:
	<input type="text" name="update_prof" value="" placeholder="">
	</p>
	<p>
	name:
	<input type="text" name="update_name" value="" placeholder="">
	tell:
	<input type="text" name="update_tell" value="" placeholder="">
	age:
	<input type="text" name="update_age" value="" placeholder="">
	birthday:
	<input type="text" name="update_birthday" value="" placeholder="">
	</p>

	<input type="submit" name="" value="送信">

	</form>	





	<form action="DBfromPHPkadai8.php" method="POST" accept-charset="utf-8">

	<p>
	レコードの追加:
	</p>

	<p>
	<p>
	name:
	<input type="text" name="update_name" value="" placeholder="">
	tell:
	<input type="text" name="update_tell" value="" placeholder="">
	age:
	<input type="text" name="update_age" value="" placeholder="">
	birthday:
	<input type="text" name="update_birthday" value="" placeholder="">
	</p>

	<input type="submit" name="" value="送信">

	</form>




	<form action="DBfromPHPkadai8.php" method="POST" accept-charset="utf-8">

	<p>
	名前、年齢、誕生日を使った複合検索ができるフォーム:
	</p>
	<p>
	name：
		<input type="text" name="multiNamesearch" value="" placeholder="">
	</p>

	<p>
		age：
		<input type="text" name="multiAgesearch" value="" placeholder="">
	</p>

	<p>
	birthday：
	<input type="text" name="multiBirthsearch" value="" placeholder="">
	</p>
	
	
	<input type="submit" name="multisearch" value="送信">
	</form>




<!-- 課題13:フォームなどを駆使して、CREATE TABLEやSELECTなど、これまで行ってきたDBへの操作がそのブラウザ上で全て完結できるようなサービスを構築してください。 -->


<!-- 課題8:検索用のフォームを用意し、名前の部分一致で検索＆表示する処理を構築してください。同じページにリダイレクトするPOST処理と、POSTに値が入っているかの条件分岐を活用すれば、一つの.phpで完了できますので、チャレンジしてみてください -->

 
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
