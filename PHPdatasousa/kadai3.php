<?php 
// 　３．クッキーに現在時刻を記録し、次にアクセスした際に、前回記録した日時を表示してください。
date_default_timezone_set('Asia/Tokyo');

$access_time = date('Y年m月d日h:i:s');
setcookie('LastLoginDate',$access_time);

$lastDate = $_COOKIE['LastLoginDate'];

echo 'お帰りなさい！○○さん！<br>';
echo '前回ログイン日は、' . $lastDate . 'です！';

// setcookieとCOOKIEの処理のタイミングがちょっとよくわかってない

 ?>