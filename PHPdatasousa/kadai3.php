<?php 
// 　３．クッキーに現在時刻を記録し、次にアクセスした際に、前回記録した日時を表示してください。
date_default_timezone_set('Asia/Tokyo');

$access_time = date('Y年m月d日h:i:s');
setcookie('LastLoginDate',$access_time);


// 初回ログイン時はクッキーにLastLoginDateがセットされていないので、'LastLoginDate'は未定義の変数として扱われる
// 未定義の変数はnullを返すので条件式は処理されるが、Notice: Undefined variable（エラー文）を吐き出す。
//未定義の変数を判定する場合はissetを使用する。変数が未定義、またはnullの場合はfaulseを返す。
if(isset($_COOKIE['LastLoginDate'])){

	$lastDate = $_COOKIE['LastLoginDate'];
	echo 'お帰りなさい！〇〇さん！<br>';
	echo '前回ログイン日は、' . $lastDate . 'です！';

	# code...
}else{
	echo '初めまして〇〇さん！';
}




// setcookieとCOOKIEの処理のタイミングがちょっとよくわかってない
// $_COOKIEに値が入るのはページを更新するタイミング。らしい。

 ?>