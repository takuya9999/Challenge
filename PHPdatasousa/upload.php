<?php
    // アップロードされたファイル情報確認
    var_dump($_FILES);

    echo "<br>";
    // サーバー側に保存する名前
    $file_name = 'upload.txt';
    // アップロードされたファイルを移動する
     // move_uploaded_fileのとる引数について調べる
    // ここら辺参照↓
    // http://www.php-ref.com/web/03_move_uploaded_file.html
    // $_FILES['userfile']['tmp_name']　これ多分[0]が省略されてる。nameが'userfile'のファイル一覧の中の[0]番目のファイルのテンポラリネームを取得するという意味。多分。
    move_uploaded_file( $_FILES['userfile']['tmp_name'], $file_name);

    $file_view = file_get_contents($file_name);
	echo "$file_view";


    ?>

