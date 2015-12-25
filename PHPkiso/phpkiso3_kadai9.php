<?php 
function kadai9($id=null)
	{
		 $user1=array(
		 "id:1<br>",
		 "名前：五郎丸<br>",
		 "生年月日：3月1日<br>",
		 "住所：福岡県福岡市<br>"
		 );

		 $user2=array(
		 "id:2<br>",
		 "名前：太郎丸<br>",
		 "生年月日：6月3日<br>",
		 null
		 );
		
		 $user3=array(
		 "id:3<br>",
		 "名前：ジローラモ<br>",
		 "生年月日：9月6日<br>",
		 "住所：イタリア<br>"
		 );

		 $user4=array(
		 "id:null<br>",
		 "無効な値が入力されています<br>"
		 );
		
		if ($id==1) {
			return $user1;
			# code...
		}
		elseif ($id==2) {
			return $user2;
	}

		elseif ($id==3) {
			return $user3;
		}

		else{
			return $prof =array($user1,$user2,$user3);
	}


	}

	foreach (kadai9() as $key => $value) {
		for ($i=0; $i <count($value) ; $i++) { 
			if ($i==0) {
			continue;
		}
			if ($value[$i]==null) {
				continue;
			}
		echo "$value[$i]";

		}
		
	}	

echo "<p>なぜ二重foreachを使わなかったのか。</p>";


	foreach (kadai9() as $key => $value) {
		foreach ($value as $key => $value) {
	
			if ($key==0) {
			continue;
		}
			if ($value==null) {
				continue;
			}
		echo "$value";

		}
		
	}


 ?>