<?php require_once '../common/defineUtil.php'; ?>
<?php require_once '../common/scriptUtil.php'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
      <title>登録確認画面</title>
</head>
  <body>
    <?php
    if(!empty($_POST['name']) && is_numeric($_POST['year']) &&  is_numeric($_POST['month']) && is_numeric($_POST['day']) &&!empty($_POST['type']) 
            && !empty($_POST['tell']) && !empty($_POST['comment'])){
        $post_name = $_POST['name'];
        //date型にするために1桁の月日を2桁にフォーマットしてから格納
        $post_birthday = $_POST['year'].'-'.sprintf('%02d',$_POST['month']).'-'.sprintf('%02d',$_POST['day']);
        $post_type = $_POST['type'];
        $post_tell = $_POST['tell'];
        $post_comment = $_POST['comment'];

        //セッション情報に格納
        // session_start();
        $_SESSION['name'] = $post_name;
        $_SESSION['birthday'] = $post_birthday;
        $_SESSION['type'] = $post_type;
        $_SESSION['tell'] = $post_tell;
        $_SESSION['comment'] = $post_comment;
        $_SESSION['year'] = $_POST['year']; 
        $_SESSION['month'] = $_POST['month']; 
        $_SESSION['day'] = $_POST['day']; 
    ?>

        <h1>登録確認画面</h1><br>
        名前:<?php echo $post_name;?><br>
        生年月日:<?php echo $post_birthday;?><br>
        種別:<?php echo $post_type?><br>
        電話番号:<?php echo $post_tell;?><br>
        自己紹介:<?php echo $post_comment;?><br>

        上記の内容で登録します。よろしいですか？

        <form action="<?php echo INSERT_RESULT ?>" method="POST">
          <input type="submit" name="yes" value="はい">
          <input type="hidden" name="true" value="">
        </form>
        <form action="<?php echo INSERT ?>" method="POST">
            <input type="submit" name="no" value="登録画面に戻る">
        </form>
        
    <?php }else{ 
        if (empty($_POST['name']) ) {
        echo "名前の入力が不完全です<br>";  
        }else{
              $_SESSION['name'] = $_POST['name'];
        }

        if ( !(is_numeric($_POST['year']) && is_numeric($_POST['month']) && is_numeric($_POST['day']))) {
        echo "生年月日の入力が不完全です<br>";  
        }else{
        $_SESSION['year'] = $_POST['year']; 
        $_SESSION['month'] = $_POST['month']; 
        $_SESSION['day'] = $_POST['day']; 
        }

        if (empty($_POST['type']) ) {
        echo "種別の入力が不完全です<br>";  
        }else{
            $_SESSION['type'] =$_POST['type'];
        }

        if (empty($_POST['tell']) ) {
        echo "電話番号の入力が不完全です<br>";  
        }else{
             $_SESSION['tell'] =$_POST['tell'];
        }

        if (empty($_POST['comment']) ) {
        echo "自己紹介の入力が不完全です<br>";  
        }else{
             $_SESSION['comment'] =$_POST['comment'];   
        }

        ?>
        <h1>入力項目が不完全です</h1><br>
        再度入力を行ってください
        <form action="<?php echo INSERT ?>" method="POST">
            <input type="submit" name="no" value="登録画面に戻る">
        </form>
    <?php }?>
    <?php  echo return_top(); ?>

</body>
</html>
