<!-- ※考える課題に関しては、考えた内容をGitHubにアップしてください。

　１．身の回りにあるものをオブジェクティブ指向で抽象化してみましょう。

	
	プロ野球

	球団
	親会社

	球場
	オーナー
	首脳陣
	選手
	審判
	観客



　　　自分が興味あるもので構いません。また、抽象化するレベルも問いません。
　２．１で作成したオブジェクトをカプセル化してください。
　　　そのオブジェクトに必要な情報を割り出しましょう。


	プロ野球

	球団
	役目：プロ野球の試合を行う
	情報：親会社、球場、オーナー、首脳陣、首脳陣、選手、ファン、応援団
	動作：プロ野球の試合の開催

	球場
	役目：試合と、試合を観戦する場所を提供する
	情報：球場名、球場のサイズ、フェンスの高さ、収容人数
	動作：

	オーナー
	役目：球団の経営を行う
	情報：
	動作：

	首脳陣
	役目：選手の獲得、起用の判断を行う
	情報：
	動作：

	選手
	役目：試合を行う
	情報：
	動作：

	審判
	役目：プレーをジャッジする
	情報：年齢、名前、ポジション
	動作：

	観客
	役目：プロ野球の収益源
	情報：ファンの球団、
	動作：チケットを買う、飲食物を買う、グッズを買う、応援する

	



　３．２で作成したオブジェクト群からクラスにできそうなものを考えましょう。
　　　クラスにどういったデータを持たせるかが重要です。
　
　４．以下の機能を持つクラスを作成してください。
　　　・パブリックな２つの変数
　　　・２つの変数に値を設定するパブリックな関数
　　　・２つの変数の中身をechoするパブリックな関数
　５．４のクラスを継承し、以下の機能を持つクラスを作成してください。
　　　・２つの変数の中身をクリアするパブリックな関数

６．以下の機能を満たすロジックを作成してください。

　　在庫管理システムを作成します。
　　まず、DBにユーザー情報管理テーブルと、商品情報登録テーブルを作成してください。
　　その上で、下記機能を実現してください。

　　①ユーザーのログイン・ログアウト機能

　　②商品情報登録機能

　　③商品一覧機能

　　※各テーブルの構成は各自の想像で作ってみてください。 -->

<?php 
class Kadai4{

	public $name="テスト";
	public $age;


	public function setvalue($name="目黒拓也",$age=26){
		$this->name=$name;
		$this->age=$age;
	}


	public function showvalue(){
// echoって関数呼び出した位置に自動で返るっぽい。return　echoって書きたい・・・書きたくない？
	 // echo $this->name.$this->age;
	 echo $this->name.$this->age;
	 // っていうか$this->オオスギィ！、こんなにいちいちthis書く必要あるのか？いや、ない。（反語）
	}

}



class Kadai5 extends Kadai4{

	public $name;
	public $age;
	public function clearvalue(){
		$this->name=null;
		$this->age=null;
}




}

$kadai4 = new Kadai4();
// $kadai4->setvalue("メヌースー",5);
$kadai4->showvalue();


$kadai5 = new Kadai5();

echo "テストです".$kadai5->name;
// $kadai5->setvalue("テスト",5);
// $kadai5->showvalue();
$kadai5->clearvalue();
$kadai5->showvalue();



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
 	
<ul>
	<li>test</li>
	<li><?php $kadai4->showvalue();?></li>
	<li>test</li>
</ul>

 </body>
 </html>