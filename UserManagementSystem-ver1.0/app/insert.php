<?php require_once '../common/defineUtil.php'; ?>
<?php require_once '../common/scriptUtil.php'; ?>
<?php 
session_start();
 
if (!isset($_POST['no'])) {
    $_SESSION['name'] = null;
    $_SESSION['year'] = '----';
    $_SESSION['month'] = '--';
    $_SESSION['day'] = '--';
    $_SESSION['type'] = '1';
    $_SESSION['tell'] = null;
    $_SESSION['comment'] = null;
}



 ?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
      <title>登録画面</title>
</head>
<body>
    <form action="<?php echo INSERT_CONFIRM ?>" method="POST">
    名前:
    <input type="text" name="name" value="<?php echo $_SESSION['name']; ?>">
    <br><br>
    
    生年月日:　
    <select name="year">
        <option value="----">----</option>
        <?php
        for($i=1950; $i<=2010; $i++){ ?>
        <option value="<?php echo $i;?>" <?php if($i==$_SESSION['year']){echo "selected";} ?> ><?php echo $i ;?></option>
        <?php } ?>
    </select>年
    <select name="month">
        <option value="--">--</option>
        <?php
        for($i = 1; $i<=12; $i++){?>
        <option value="<?php echo $i;?>" <?php if($i==$_SESSION['month']){echo "selected";} ?> ><?php echo $i;?></option>
        <?php } ;?>
    </select>月
    <select name="day">
        <option value="--">--</option>
        <?php
        for($i = 1; $i<=31; $i++){ ?>
        <option value="<?php echo $i; ?>" <?php if($i==$_SESSION['day']){echo "selected";} ?> ><?php echo $i;?></option>
        <?php } ?>
    </select>日
    <br><br>

    種別:
    <br>
    <input type="radio" name="type" value="1" <?php if($_SESSION['type']=="1")echo "checked"; ?>>エンジニア<br>
    <input type="radio" name="type" value="2" <?php if($_SESSION['type']=="2")echo "checked"; ?>>営業<br>
    <input type="radio" name="type" value="3" <?php if($_SESSION['type']=="3")echo "checked"; ?>>その他<br>
    <br>
    
    電話番号:
    <input type="text" name="tell" value="<?php echo $_SESSION['tell']; ?>">
    <br><br>

    自己紹介文
    <br>
    <textarea name="comment" rows=10 cols=50 style="resize:none" wrap="hard" ><?php echo $_SESSION['comment']; ?></textarea><br><br>
    
    <input type="submit" name="btnSubmit" value="確認画面へ">
    </form>
    <?php  echo return_top(); ?>
</body>
</html>
