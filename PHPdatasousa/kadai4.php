<?php 


// ４．３と同じ機能をセッションで作成してください。
date_default_timezone_set('Asia/Tokyo');
// sessionっていきなり'message'みたいな変数名作っていいぽい？なんか不思議やね
    // セッション開始
    session_start();
if ($_SESSION['message']) {
    echo $_SESSION['message'];
		# code...
}

	$access_time = date('Y年m月d日h:i:s');
    // セッションに情報を入れる。
    $_SESSION['message'] = $access_time;
 ?>