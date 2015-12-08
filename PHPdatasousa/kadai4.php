<?php 


// ４．３と同じ機能をセッションで作成してください。
date_default_timezone_set('Asia/Tokyo');

    session_start();
if ($_SESSION['message']) {
    echo $_SESSION['message'];
		# code...
}

    // セッション開始
	$access_time = date('Y年m月d日h:i:s');
    // セッションに情報を入れる。
    $_SESSION['message'] = $access_time;

 ?>