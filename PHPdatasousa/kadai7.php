<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>


<?php 
	if(isset($_COOKIE['ProfData'])) {
		$lastDate =$COOKIE['ProfData'];
		$name = $lastDate[0];
		$seibetu =$lastDate[1];
		$hobby = $lastDate[2];		
	}else{
	$name = "あ";
	$seibetu="";
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
		<input type="radio" name="seibetu" value="男" placeholder="">
		男
		<input type="radio" name="seibetu" value="女" placeholder="">
		女</p>
	
	<p>
		趣味：
		<textarea name="hobby">
			<?php echo "$hobby" ?>
		</textarea>
	</p>
		<input type="submit" name="" value="送信">
	</form>

	<?php 
	echo "$nameです";
	?>
</body>
</html>