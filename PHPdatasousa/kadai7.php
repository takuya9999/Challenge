<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>


<?php 
	if(isset($_COOKIE['name'])) {
		$name =$_COOKIE['name'];
	}else{
	$name = "　";

	}


	if(isset($_COOKIE['female'])) {
		$female =$_COOKIE['female'];
	}else{
		$female = null;
	}
	if(isset($_COOKIE['male'])) {
		$male =$_COOKIE['male'];
	}else{
		$male= null;
	}
	echo "$male";
	// テキストエリアは何も入ってなくても'空文字'が入力されていると判断されisset==trueが返されるので、
	// この場合↓、必ずtrueが返ってしまうのでelseを書く意味がない。
	// 文字が入力されているかどうかを判断する場合、emptyを使うのが良いらしい・・・盗み聞きしてただけなので確証はない。
	if(isset($_COOKIE['hobby'])) {
		$hobby =$_COOKIE['hobby'];
	}else{
	$hobby = "";
	}
 ?>


	<form action="kadai7submit.php" method="POST" accept-charset="utf-8">
	<p>
	名前：
	<input type="text" name="name" value="<?php echo $name;?>" placeholder="">
	</p>
	
	<p>
		性別：
		<input type="radio" name="seibetu" value="男" <?php echo $male;?> placeholder="">
		男
		<input type="radio" name="seibetu" value="女" <?php echo $female;?>  placeholder="">
		女</p>
	
	<p>趣味：<textarea name="hobby"><?php echo $hobby; ?></textarea></p>
	<input type="submit" name="" value="送信">
	</form>

	<?php 
	echo "$name"."です";
	echo "$nameですだとエラーが出るよ";
	?>
</body>
</html>
