<?php

//DBへの接続用を行う。成功ならPDOオブジェクトを、失敗なら中断、メッセージの表示を行う
function connect2MySQL(){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=Challenge_db;charset=utf8','takuya','9999');
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
// setattributeでexceptionを設定しないと例外処理のオブジェクト(PDOException $e)が返ってこない？
        return $pdo;
    } catch (PDOException $e) {
        die('接続に失敗しました。次記のエラーにより処理を中断します:'.$e->getMessage());
    }
}

function insertprof($name,$birthday,$type,$tell,$comment){


	 try{
    //DBに全項目のある1レコードを登録するSQL
    // $insert_sql = "INSERT INTO user_t(name,birthday,tell,type,comment,newDate)"
    //         . "VALUES(:name,:birthday,:tell,:type,:comment,:newDate)";

$insert_sql = "INSERT INTO user_t(name,birthday,tell,type,comment,newDate)"
            . "VALUES(:name,:birthday,:tell,:type,:comment,:newDate)";

    //クエリとして用意
    $insert_db =connect2MySQL();
    $insert_query = $insert_db->prepare($insert_sql);

    //SQL文にセッションから受け取った値＆現在時をバインド
    $insert_query->bindValue(':name',$name);
    $insert_query->bindValue(':birthday',$birthday);
    $insert_query->bindValue(':tell',$tell);
    $insert_query->bindValue(':type',$type);
    // $insert_query->bindValue(':type','あ');
    $insert_query->bindValue(':comment',$comment);
    // $insert_query->bindValue(':newDate',time());
    $insert_query->bindValue(':newDate',date("y-m-d H:i:s"));
    
    //SQLを実行
    $insert_query->execute();
    
    // if(!$insert_query->execute()){
    //     echo "エラー";
    // }


    //接続オブジェクトを初期化することでDB接続を切断
    $insert_db=null;
}catch(PDOException $e){
    echo "データの挿入に失敗しました:".$e->getMessage();
}
}