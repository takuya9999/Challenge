<?php
    // アップロードされたファイル情報確認
    var_dump($_FILES);

    echo "<br>";
    // サーバー側に保存する名前
    $file_name = 'upload.txt';
    // アップロードされたファイルを移動する
     // move_uploaded_fileのとる引数について調べる
    move_uploaded_file( $_FILES['userfile']['tmp_name'], $file_name);

    $file_view = file_get_contents($file_name);
	echo "$file_view";


    ?>

