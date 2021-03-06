<?php 
// 　１．DBに人の情報を入れたテーブルを作成してください。
// 　２．DBに駅の情報を入れたテーブルを作成してください。
// 　３．baseという抽象クラスを作成し、以下を実装してください。
// 　　・loadというprotectedな関数を用意してください。
// 　　・showという公開関数を用意してください。
// 　４．３で作成した抽象クラスを継承して、以下のクラスを作成してください。
// 　　・人の情報を扱うHumanクラス
// 　　・駅の情報を扱うStationクラス
// 　　また、各クラスに隠匿変数でtableという変数を用意し、各クラスの初期化処理で
// 　　table変数にテーブル名を設定してください。
// 　５．load関数でDBから全情報を取得するように各クラスの関数を実装してください。
// 　　その際、table変数を利用して、データを取得するようにしてください。
// 　６．show関数で各テーブルの情報の一覧が表示されるようにしてください。 
 


// <?php の前に行が入ってるとheader関数がエラーになるみたい




//  function addcol($object ,$table , $col, $type){
//  $object->exec("ALTER TABLE $table ADD $col $type;");
// }
//接続の確立



define('DB_DATABASE','Challenge_db');
define('DB_USERNAME','takuya');
define('DB_PASSWORD','9999');
define('PDO_DSN','mysql:dbhost=localhost;dbname='.DB_DATABASE);




  abstract class base { 
  	abstract protected function load();
  	abstract public function show();
}

// -------------------------↓Hunmanクラス-----------------------------------------------------


    class Human extends base{

    	// public $stmt;
      // public $thstmt;
    	public $th;
        private $table;
        private $use;
        private $pdo_object ;

    	function  __construct($tablename){
    		$this->table=$tablename;
    	}






    	  function load(){

 // 定数の定義
// define('DB_DATABASE','Challenge_db');
// define('DB_USERNAME','takuya');
// define('DB_PASSWORD','9999');
// define('PDO_DSN','mysql:dbhost=localhost;dbname='.DB_DATABASE);

// ステートメントハンドラにmysqlの実行結果を格納

    	try{
$this->pdo_object = new PDO(PDO_DSN , DB_USERNAME,DB_PASSWORD);
$this->pdo_object->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$stmt= $this->pdo_object->query("select * from $this->table");
$this->use =$stmt->fetchALL(PDO::FETCH_ASSOC);
		// var_dump($this->use);
$thstmt = $this->pdo_object->query("desc $this->table");
$this->th=$thstmt->fetchALL(PDO::FETCH_BOTH);

// 配列をオフセット（0,1,2....）で取得したい時はFETCH_BOTHを使用する


$this->pdo_object = null;
}catch(PDOException $e){
// エラーメッセージ
echo $e->getMessage();
exit;
}

		
        }

        function show(){


echo "現在のテーブルは<font color='#FF0000'>".$this->table."</font>です";
echo '<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">';
echo "<tr>";
  // var_dump($this->th);

foreach ($this->th as $key => $value) {
  // var_dump($value);
echo '<th bgcolor="#EE0000" align="right" nowrap><font color="#FFFFFF">'.$value[0].'</font></th>';
    
  }
echo "</tr>";

// ------------------------------------------------------------
// テーブルの内容を一覧表示させる処理
// この処理を一番最初に書いてしまうと、商品情報に変更、追加があった場合のmysql実行結果が表示に反映されないので、
// フォームの処理の後に記述する

foreach($this->use as $key => $value) {
	echo "<tr>";
	// $use[$key] よりもスマートな指定方法ってあるのん？$valueじゃダメだったっけ？
	foreach ($this->use[$key] as $key => $value) {
		echo '<td bgcolor="#99CC00" align="right" nowrap>'."$value".'</td>';
		
	}
		echo "</tr>";
	}

	echo "</table>";







        }
    

}
// -------------------------↑Hunmanクラス-----------------------------------------------------


   


// -------------------------↓Stationクラス-----------------------------------------------------

// コードの内容がHumanクラスと同じなので割愛

// -------------------------↑Stationクラス-----------------------------------------------------







   $human = new Human("OBJ2human");
   $station = new Human("OBJ2station");
   // $station = new Human("OBJ2station");

   $human->load();
   $human->show();

   $station->load();
   $station->show();

 //    class Station extends base{
 //         private $table;
 //    	function  __construct($tablename){
 //    		$this->table=$tablename;
	//     }

	//     function load(){

	//     }

	//     function show(){}
	// }



// ステートメントハンドラを実行した時に返ってくるものが何なのか理解していない。
// 例えば、prepareを使用した場合は、その段階でステートメントハンドラ用の変数に代入している、
// queryを使用した場合は、実行した段階でステートメントハンドラが命令を実行してしまっているので、
// その段階でステートメントハンドラ用の変数に代入するしかないのだが、明らかに、この二つは違う段階の処理結果が入っている。

// 具体例を挙げると、prepareは下記のようになる
// $stmt = $pdo_object->prepare("select * from user_info where username = :username and pass = :pass");
// $stmt->execute([":username"=>$username,":pass"=>$pass]);

// queryは下記のようになる
// $stmt = $pdo_object->query("desc $table");

// たぶん、$stmt->executeをした時に、$stmtにどのような処理が起きてるかが理解してないのが問題だと思う。
// $stmt->executeを実行した時に、$stmtになにが帰ってくるのか、それが理解できていない。




// 定数を定義する位置が謎。動いてるからいいか！みたいになってる

 ?>