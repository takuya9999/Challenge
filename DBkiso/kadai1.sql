create table profiles(
profilesID int not null auto_increment primary key ,　
name varchar(255),
tell varchar(255) unique,
age int,
birthday date
);

insert into profiles(name,tell,age,birthday) values
	('田中　実','012-345-6789',30,'1994-02-01'),
	('鈴木　茂','090-1122-3344',37,'1987-08-12'),
	('鈴木　実','080-5566-7788',24,'2000-12-24'),
	('佐藤　清','012-0987-6543',19,'2005-08-01'),
	('高橋　清','090-9900-1234',24,'2000-12-24');



	insert into profiles(profilesID,name,tell,age,birthday) values
	(3,'鈴木　実','080-5566-7788',24,'2000-12-24'),
	(5,'高橋　清','090-9900-1234',24,'2000-12-24');


-- 全カラムに値を入れる場合はフィールド名を省略できる
INSERT INTO tbl_name VALUES (value1, value2, ...);



課題9:このリンクにあるようなテーブル群をCREATEし、
記述されているレコードをINSERTしてください。
CREATE時には同時に主キーと外部キーの指定もしてください
(Primary Key と Foreign Keyを宣言)。
全件INSERT後、SELECT *を実行することにより全要素を表示してください。



create table user(
userID int not null auto_increment ,
name varchar(255),
tell varchar(255) ,
age int,
birthday date,
departmentID int,
stationID int,
primary key (userID),
Foreign key (departmentID) references department (departmentID),
Foreign key (stationID) references station (stationID)
);



insert into user(name,tell,age,birthday,departmentID, stationID) values
	('田中　実','012-345-6789',30,'1994-02-01',3,1),
	('鈴木　茂','090-1122-3344',37,'1987-08-12',3,4),
	('鈴木　実','080-5566-7788',24,'2000-12-24',2,5),
	('佐藤　清','012-0987-6543',19,'2005-08-01',1,5),
	('高橋　清','090-9900-1234',24,'2000-12-24',3,5);

create table department(
departmentID int auto_increment primary key,
departmentName varchar(255) 
);

-- なんでdepartmentNameにuniqueつけると231の順で入るのん？

insert into department(departmentName) values
	('開発部'),
	('営業部'),
	('総務部');



create table station(
stationID int auto_increment primary key,
stationName varchar(255) 
);

-- stationNameにuniqueつけると54321の順で入るのんなー？



insert into station(stationName) values
	('九段下'),
	('永田町'),
	('渋谷'),
	('神保町'),
	('上井草');



-- Foreign key を指定するときにリファレンス先がないとエラー出てダメ


これ入らなかったんなー
-- key departmentID (departmentID),
-- key stationID (stationID)






create table user2(
userID int not null auto_increment primary key,
name varchar(255),
age int
);



 SQLdumpをしてみようず！！
 -- create table　で作成したテーブの情報を一覧表示
show create table ユーザー名;

インデックスの名前はIDX_フィールド名みたいな感じで書いたりする

Foreign key はcreate table時に記述するか、alterだったかで追加する。

Foreign key　は　勝手に作っちゃいけないレコードの値を作らせないようにするのに使う。
どういうことかってーと、foreign keyでは指定したテーブルの主キーを参照するため、
参照元にないレコードの値は取得できない。

Foreign key を設定したフィールドと参照先の関係は変数のリファレンスみたいな関係ってことやね。

join , union　コマンドの使い方覚える