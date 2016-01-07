<!-- ６．以下の機能を満たすロジックを作成してください。

　　在庫管理システムを作成します。
　　まず、DBにユーザー情報管理テーブルと、商品情報登録テーブルを作成してください。
　　その上で、下記機能を実現してください。

　　①ユーザーのログイン・ログアウト機能

　　②商品情報登録機能

　　③商品一覧機能 -->

<!-- 
user_info
ID
ユーザー名
パスワード


product_info
商品ID
商品名　unique？
値段
個数

create table user_info(
userID int not null auto_increment primary key,
username varchar(255) not null,
pass varchar(255) not null
);

create table product_info(
productID int not null auto_increment primary key,
productname varchar(255),
price int,
number int
);


insert into profiles(name,tell,age,birthday) values
	('田中　実','012-345-6789',30,'1994-02-01'),
	('鈴木　茂','090-1122-3344',37,'1987-08-12'),
	('鈴木　実','080-5566-7788',24,'2000-12-24'),
	('佐藤　清','012-0987-6543',19,'2005-08-01'),
	('高橋　清','090-9900-1234',24,'2000-12-24');

insert into user_info(username,pass) values
	('田中　たなこ','1234567'),
	('田所　こうじ','114514');


insert into product_info(productname,price,number) values
	('ガリガリ君',60,20);

 -->




 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title></title>
 	<link rel="stylesheet" href="">
 </head>
 <body>


	<form action="OBJ_1_kadai6_login.php" method="POST" accept-charset="utf-8">
	<p>ログイン</p>
	<p>
	ユーザー名：
	<input type="text" name="username" value="" placeholder="">
	</p>
	<p>
	パスワード：
	<input type="text" name="pass" value="" placeholder="">
	</p>	
	<input type="submit" name="" value="送信">
	</form>
 	
 </body>
 </html>