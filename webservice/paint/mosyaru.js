
var lines = new Array();
var color;
//描画中かどうかを表すフラグ
var isanimation= false;
var isDrawing= false;
var width =10; //現在の線幅
var isBW = false;
var startX,startY;
var endX=null;
var endY=null;
var cursoroffset =0;
var getbrush;
var getairbrush;
var getEraser;
var getairEraser;
var getLighterbrush;
var getEffectbrush;
var opacity =100;
var r,g,b;
// layer control
var activelayer;
var activelayer_num;
var last_activelayer_num
var frontlayer;
var layers;
var checklayer_num;
var eyes;
var eyelayer_num;
var canvasItems = [];
var ctx;
var canvas_w ,canvas_h;
var picker;
var effect=false;
var canavs_scale=3;




/*------------------------レイヤーの初期化---------------------------*/
/*----------------------------レイヤーの作成-------------------------------*/

	$("#addlayerbutton").live("click",function(){

		if(layers.length>=13) return;
		
		$("#layerArea").prepend("<span><input type='checkbox' name='visibleLayer' id='visibleLayer1' checked><label><input type='radio' name='selectLayer' checked>layer"+(layers.length+1)+"<br></label></span>");
		$("#canvasArea").append('<canvas  width="1200" height="800"></canvas>').clone(true);
		$("#canvasArea").append('<canvas  class="opacity" width="1200" height="800"></canvas>').clone(true);


		canvas =$("canvas");
		frontlayer = canvas[canvas.length-1];//手前レイヤー
		ctx=frontlayer.getContext("2d");
		 ctx.scale(1,1);
			//window.alert(canvas.length-1+"unko");

		layers =$("input[name='selectLayer']");//レイヤーボックスに表示されている全てのレイヤー要素
		eyes=$("input[name='visibleLayer']");//レイヤーボックスに表示されている全てのチェックボックス要素

		//window.alert(layers.length+","+eyes.length+","+"unko");

		for(var i=0; i< layers.length; i++){
		if(layers[i].checked){
		checklayer_num=i;
		activelayer_num = (layers.length-(i+1))*2+1;
			}
		}
		//window.alert(activelayer_num+"unko");
		activelayer =canvas[activelayer_num];//アクティブレイヤー(要素)
		context=$(activelayer).get(0).getContext('2d');
		$(canvas[activelayer_num-1]).css("opacity",1); //転写レイヤーの初期化
		$("canvas.opacity").css("opacity",opacity/100);//アクティブレイヤー群の初期化
		
	
	});
/*--------------------------------------------レイヤーの複製--------------------------------------------------------*/
	$("#copy").live("click",function(){

		
		
		$("#layerArea").prepend("<span><input type='checkbox' name='visibleLayer' id='visibleLayer1' checked><label><input type='radio' name='selectLayer' checked>layer"+(layers.length+1)+"<br></label></span>");
		$("#canvasArea").append('<canvas  width="600" height="400"></canvas>').clone(true);
		$("#canvasArea").append('<canvas  class="opacity" width="600" height="400"></canvas>').clone(true);



		canvas =$("canvas");
		frontlayer = canvas[canvas.length-1];//手前レイヤー
		ctx=frontlayer.getContext("2d");


		//レイヤーの転写処理	
		canvas[canvas.length-2].getContext("2d").globalCompositeOperation = 'source-over';
		canvas[canvas.length-2].getContext("2d").globalAlpha = 1;
		canvas[canvas.length-2].getContext("2d").drawImage(canvas[activelayer_num-1], 0, 0);




			//window.alert(canvas.length-1+"unko");

		layers =$("input[name='selectLayer']");//レイヤーボックスに表示されている全てのレイヤー要素
		eyes=$("input[name='visibleLayer']");//レイヤーボックスに表示されている全てのチェックボックス要素

		//window.alert(layers.length+","+eyes.length+","+"unko");


		for(var i=0; i< layers.length; i++){
		if(layers[i].checked){
		checklayer_num=i;
		activelayer_num = (layers.length-(i+1))*2+1;
			}
		}
		//window.alert(activelayer_num+"unko");
		activelayer =canvas[activelayer_num];//アクティブレイヤー(要素)
		context=$(activelayer).get(0).getContext('2d');
		$(canvas[activelayer_num-1]).css("opacity",1); //転写レイヤーの初期化
		$("canvas.opacity").css("opacity",opacity/100);//アクティブレイヤー群の初期化
				
	});

/*-------------------------------レイヤー削除----------------------------------------------*/

//将来的にラジオボックス廃止、名前の変更ができる要素に変更

	$("#removelayerbutton").live("click",function(){


		if(layers.length ==1) return;//レイヤーが一枚しかなかったらリターン


		$($("#layerArea span")[checklayer_num]).remove();//レイヤーエリアのレイヤー要素(span)削除
		$(canvas[activelayer_num]).remove();//アクティブレイヤーの削除
		$(canvas[activelayer_num-1]).remove();//アクティブの転写レイヤー削除


		canvas =$("canvas");
		frontlayer = canvas[canvas.length-1];//手前レイヤー,いらない子dewanai!?wwwww
		ctx=frontlayer.getContext("2d");
			//window.alert(canvas.length-1+"unko");

		layers =$("input[name='selectLayer']");//レイヤーボックスに表示されている全てのレイヤー要素
		eyes=$("input[name='visibleLayer']");//レイヤーボックスに表示されている全てのチェックボックス要素
		
		$(layers[0]).attr("checked","true");//レイヤーの一番上にチェック,テキスト要素実装後は無効にする

		//window.alert(layers.length+","+eyes.length+","+"unko");

//-----レイヤーの初期化(テキスト要素実装後は無効にする)--------------

		for(var i=0; i< layers.length; i++){
		if(layers[i].checked){
		activelayer_num = (layers.length-(i+1))*2+1;
			}
		}
		
		activelayer =canvas[activelayer_num];//アクティブレイヤー(要素)
		context=$(activelayer).get(0).getContext('2d');
		
		$("canvas.opacity").css("opacity",opacity/100);

//---------------------------------------------------------------------		
	});

/*--------------------------------------レイヤーの結合----------------------------------------------*/

	$("#composite").live("click",function(){

 	if(activelayer_num-1 ==0) return;//選択レイヤーが一番下の場合リターン
 

//レイヤーの転写処理	
	canvas[activelayer_num-3].getContext("2d").globalCompositeOperation = 'source-over';
	canvas[activelayer_num-3].getContext("2d").globalAlpha = 1;
	canvas[activelayer_num-3].getContext("2d").drawImage(canvas[activelayer_num-1], 0, 0);
	


//レイヤー削除処理
	$($("#layerArea span")[checklayer_num]).remove();//レイヤーエリアのレイヤー要素(span)削除
		$(canvas[activelayer_num]).remove();//アクティブレイヤーの削除
		$(canvas[activelayer_num-1]).remove();//アクティブの転写レイヤー削除


		canvas =$("canvas");
		frontlayer = canvas[canvas.length-1];//手前レイヤー,いらない子
		ctx=frontlayer.getContext("2d");
			//window.alert(canvas.length-1+"unko");

		layers =$("input[name='selectLayer']");//レイヤーボックスに表示されている全てのレイヤー要素
		eyes=$("input[name='visibleLayer']");//レイヤーボックスに表示されている全てのチェックボックス要素
		
		$(layers[layers.length-((activelayer_num-3)/2+1)]).attr("checked","true");//選択レイヤーにチェック

		//window.alert(layers.length+","+eyes.length+","+"unko");

//-----レイヤーの初期化(テキスト要素実装後は無効にする)--------------

		for(var i=0; i< layers.length; i++){
		if(layers[i].checked){
		activelayer_num = (layers.length-(i+1))*2+1;
			}
		}
		
		activelayer =canvas[activelayer_num];//アクティブレイヤー(要素)
		context=$(activelayer).get(0).getContext('2d');
		
		$("canvas.opacity").css("opacity",opacity/100);
		

	});

/*------------------------------レイヤー切り替え--------------------------------*/
	$(layers).live("click",function(){
		
		for(var i=0; i< layers.length; i++){
		if(layers[i].checked){
		activelayer_num = (layers.length-(i+1))*2+1;
			}
		}

		activelayer =$("canvas")[activelayer_num];//アクティブレイヤー(要素)
		context=$(activelayer).get(0).getContext('2d');


	});

/*---------------------------レイヤー表示・非表示切り替え-------------------------------*/



	$("input[name='visibleLayer']").live("click",function(){
			for(var i=0; i<eyes.length; i++){
				eyelayer_num = (eyes.length-(i+1))*2;//レイヤーインデックス
				if(eyes[i].checked){	// レイヤー表示のチェックが入っているかどうか
				 
					$(canvas[eyelayer_num]).css("visibility","visible");	// レイヤーを表示
				}
				else{
					$(canvas[eyelayer_num]).css("visibility","hidden");	// レイヤーを非表示
				}
			}
		
		});

/*----------------------------------レイヤー入れ替え------------------------------------*/
	$("#upbutton").live("click",function(){

		//canvas =$("canvas");

		if(!canvas[activelayer_num+2]) return;

		$(canvas[activelayer_num+2]).after(canvas[activelayer_num-1],canvas[activelayer_num]);
		$(layers[layers.length-((activelayer_num-1)/2+1)]).attr("checked","false");//選択レイヤーのチェックをはずす
		$(layers[layers.length-((activelayer_num+1)/2+1)]).attr("checked","true");//選択レイヤーにチェック

		for(var i=0; i< layers.length; i++){
		if(layers[i].checked){
		activelayer_num = (layers.length-(i+1))*2+1;
			}
		}
		
		activelayer =$("canvas")[activelayer_num];//アクティブレイヤー(要素)
		context=$(activelayer).get(0).getContext('2d');
		
		$("canvas.opacity").css("opacity",opacity/100);

		canvas =$("canvas");		
		frontlayer = canvas[canvas.length-1];//手前レイヤー,いらない子
		ctx=frontlayer.getContext("2d");

	});



	$("#downbutton").live("click",function(){

		//canvas =$("canvas");

		if(!canvas[activelayer_num-3]) return;

		$(canvas[activelayer_num-3]).before(canvas[activelayer_num-1],canvas[activelayer_num]);
		$(layers[layers.length-((activelayer_num-1)/2+1)]).attr("checked","false");//選択レイヤーにチェック
		$(layers[layers.length-((activelayer_num-3)/2+1)]).attr("checked","true");//選択レイヤーにチェック



		for(var i=0; i< layers.length; i++){
		if(layers[i].checked){
		activelayer_num = (layers.length-(i+1))*2+1;
			}
		}
		
		activelayer =$("canvas")[activelayer_num];//アクティブレイヤー(要素)
		context=$(activelayer).get(0).getContext('2d');
		
		$("canvas.opacity").css("opacity",opacity/100);

		canvas =$("canvas");
		frontlayer = canvas[canvas.length-1];//手前レイヤー,いらない子
		ctx=frontlayer.getContext("2d");


	});

/*------------------------------ブラシサイズスライダー-----------------------------*/
	$("#widthslider").slider({
         min: 1, 
        max: 100, // ブラシの最大サイズ

         value : 10,  // 最初のブラシサイズ
         slide : function(evt, ui){
             width = ui.value; // ブラシサイズを設定
	$("#bw").val(width);
        
	 }
     });
/*---------------------------------透明度スライダー--------------------------------*/
	$("#opacityslider").slider({
         min: 0, 
        max: 100, // ブラシの最大サイズ
         value : 100,  // 最初のブラシサイズ
         slide : function(evt, ui){
             opacity = ui.value; // ブラシサイズを設定
	$("#op").val(opacity);
       

	$("canvas.opacity").css("opacity",opacity/100);
	 }
     });

/*--------------------ブラシ切り替え時のエフェクト停止処理-------------------------*/

/*------------------------undo-----------------------------*/

	$("#undoButton").click(function(){ //undo
		if(lines.length >0){
			
		canvas[activelayer_num-1].getContext("2d").putImageData(lines[lines.length-1],0,0);
		lines.pop();
		}

	});


/*-----------------------------塗りつぶし-------------------------------*/

	$("#fillbutton").click(function(){

		if(!eyes[(eyes.length-1)-((activelayer_num -1)/2)].checked) return;

		getImage = canvas[activelayer_num-1].getContext("2d").getImageData(0, 0, $(activelayer).width(), $(activelayer).height());
        	lines.push(getImage);
		if($("#lock").attr("checked")){
			canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'source-atop';
			}		
		canvas[activelayer_num-1].getContext("2d").globalAlpha = opacity/100;   //塗りつぶし時の透明度の設定
		canvas[activelayer_num-1].getContext("2d").fillStyle = color;
    		canvas[activelayer_num-1].getContext("2d").fillRect(0, 0, $(activelayer).attr("width"), $(activelayer).attr("height"));

		canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'source-over'; 

	});


/*----------------------------------透明で塗りつぶし(レイヤー透明度実装までの代わり)-----------------------------------*/

	$("#fillopacitybutton").click(function(){

		if(!eyes[(eyes.length-1)-((activelayer_num -1)/2)].checked) return;


		canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'destination-out';

		getImage = canvas[activelayer_num-1].getContext("2d").getImageData(0, 0, $(activelayer).width(), $(activelayer).height());
        	lines.push(getImage);
		if($("#lock").attr("checked")){
			canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'source-atop';//不透明度の保護にチェックが入っていた場合の合成モード
			}		
		canvas[activelayer_num-1].getContext("2d").globalAlpha = opacity/100;   //塗りつぶし時の透明度の設定
		canvas[activelayer_num-1].getContext("2d").fillStyle = color;
    		canvas[activelayer_num-1].getContext("2d").fillRect(0, 0, $(activelayer).attr("width"), $(activelayer).attr("height"));

		canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'source-over'; 

	});
/*-----------------全消去-------------------------*/

	$("#clearButton").click(function(){ 	
	$(canvas[activelayer_num-1]).clearCanvas();
	});


/*---------------------------------------スポイト------------------------------------------*/

	$("canvas").live("click",function(e) {
	
   	 var getspuit = $("#spuit").attr("checked");
    	if(getspuit){
	canvas =$("canvas");	
    	frontlayer = $("canvas")[canvas.length-1];
	for(var i=eyes.length-1; i>=0; i--){
		if(eyes[i].checked){
		frontlayer.getContext("2d").globalCompositeOperation = 'source-over';
		frontlayer.getContext("2d").drawImage(canvas[(eyes.length-1-i)*2], 0, 0);
		}

	}

	var spuitImage = frontlayer.getContext("2d").getImageData(startX, startY, 1, 1);
    	
	

	r = spuitImage.data[0];
    	g = spuitImage.data[1];
    	b = spuitImage.data[2];



    	spuit_color = new RGBColor('rgb(' + r +','+ g + ',' + b +')');
	picker.setColor(spuit_color.toHex());
	color =picker.color;//これいる？
    	$(frontlayer).clearCanvas();

		}
	});

/*---------------------------------------マウスダウン---------------------------------------*/

		$("canvas").live("mousedown",function(e){

		//if(getEffectbrush)
		//clearInterval(effect);



		canvas=$("canvas");
		
		getbrush = $('#brush').is(':checked');
		getairbrush = $('#airbrush').is(':checked');
		getairEraser=$('#airEraser').is(':checked');
		getEraser=$('#Eraser').is(':checked');
		getLighterbrush=$('#lighterbrush').is(':checked');
		getEffectbrush=$("#effectbrush").is(":checked");			
		var offset =e.target.getBoundingClientRect();//windowの左上から要素(キャンパス)までの距離



		startX =e.clientX*canavs_scale - offset.left*canavs_scale-cursoroffset;
		startY =e.clientY*canavs_scale - offset.top*canavs_scale-cursoroffset;
	
			
		//描画ツールを選択している場合、フラグがたつ。前回までの描画データが保存される
	
		if(getbrush || getairbrush || getEraser || getairEraser || getEffectbrush || getLighterbrush ){
		context.globalCompositeOperation = "source-over";
		isDrawing =true;
		getImage = canvas[activelayer_num-1].getContext("2d").getImageData(0, 0, $(activelayer).width(), $(activelayer).height());
        	lines.push(getImage);	}





		if(getEffectbrush){
		effect=setInterval(Draw,16);

			}
		return false;
		});

/*------------------------------------------------------マウスムーブ-------------------------------------------------------*/

	//$(frontlayer).live("mousemove",function(e){
	$("canvas").live("mousemove",function(e){

		var offset =e.target.getBoundingClientRect();

		


		endX =e.clientX*canavs_scale - offset.left*canavs_scale-cursoroffset;
		endY =e.clientY*canavs_scale - offset.top*canavs_scale-cursoroffset;



		$("#point").html("x:"+Math.floor(endX) + "," + "y:"+Math.floor(endY));


	


		//window.alert(!eyes[(activelayer_num -1)/2].checked+"unko");
		if (!isDrawing ||  !eyes[(eyes.length-1)-((activelayer_num -1)/2)].checked ) return;

/*-----------------------------発光ブラシ--------------------------------*/

		if(getLighterbrush){

		context.globalCompositeOperation = "lighter";
		//発光ブラシ　グラデーションの開始位置の中心、直径(半径かも)、終了位置の中心と直径(半径かも)
		var grad  = context.createRadialGradient(startX, startY, 0, startX, startY, width);
		//発光シンプルブラシ
		//var grad  = context.createRadialGradient(startX, startY, width/2, startX, startY, width);
		var rgbacolor = color;
		//var rgba_endcolor=color;
		rgbacolor.replace("rgb","rgba");
		rgbacolor.replace(")",",1)");

		//rgba_endcolor.replace("rgb","rgba");
		//rgba_endcolor.replace(")",",0)");

		//グラデーションの色と透明度指定　0が開始地点、１が終了地点
    		grad.addColorStop(0, rgbacolor);
		//grad.addColorStop(1, rgba_endcolor);
    		grad.addColorStop(1, "rgba(0, 0, 0, 0)");
	
	if($("#lock").attr("checked")){
		$(activelayer).css("opacity",0);
	    }


	    //context.globalAlpha = 1;
	    
            context.beginPath();
            context.strokeStyle = grad;
            context.lineWidth = width*2;
            context.lineJoin= 'round';
            context.lineCap = 'round';
            context.shadowBlur = 0;
            context.setTransform(1, 0, 0, 1, 0, 0);
            context.moveTo(startX, startY);
            context.lineTo(endX, endY);
            context.stroke();
            context.closePath();

	if($("#lock").attr("checked")){
		canvas[activelayer_num-1].getContext("2d").putImageData(lines[lines.length-1],0,0);//転写レイヤーを描画前のイメージで初期化
		canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'source-atop';//転写時の合成モード
		canvas[activelayer_num-1].getContext("2d").globalAlpha = opacity/100; //転写時の透明度
		canvas[activelayer_num-1].getContext("2d").drawImage(activelayer, 0, 0);//アクティブレイヤーを転写
		}
	}

/*-----------------------------------エアブラシ-----------------------------------------*/
	else if(getairbrush){

	
		if($("#lock").attr("checked")){
		$(activelayer).css("opacity",0);
	    }

          
            context.beginPath();
            
            context.strokeStyle = color;
            context.lineWidth = width*0.75;
            context.lineJoin= 'round';
            context.lineCap = 'round';
            context.shadowBlur = width*0.75;
            context.shadowColor = color;
            context.setTransform(1, 0, 0, 1, 0, 0);
            context.moveTo(startX, startY);
            context.lineTo(endX, endY);
            context.stroke();
            context.closePath();
		if($("#lock").attr("checked")){
		canvas[activelayer_num-1].getContext("2d").putImageData(lines[lines.length-1],0,0);//転写レイヤーを描画前のイメージで初期化
		canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'source-atop';//転写時の合成モード
		canvas[activelayer_num-1].getContext("2d").globalAlpha = opacity/100; //転写時の透明度
		canvas[activelayer_num-1].getContext("2d").drawImage(activelayer, 0, 0);//アクティブレイヤーを転写
		}
	}
/*----------------------------ノーマルブラシ------------------------------*/

		else if(getbrush){


		if($("#lock").attr("checked")){
		$(activelayer).css("opacity",0);
	    }
		

		
	    context.globalAlpha = 1;
	    
            context.beginPath();
            context.strokeStyle = color;
            context.lineWidth = width;
            context.lineJoin= 'round';
            context.lineCap = 'round';
            context.shadowBlur = 0;
            context.setTransform(1, 0, 0, 1, 0, 0);
            context.moveTo(startX, startY);
            context.lineTo(endX, endY);
            context.stroke();
            context.closePath();


		if($("#lock").attr("checked")){
		canvas[activelayer_num-1].getContext("2d").putImageData(lines[lines.length-1],0,0);//転写レイヤーを描画前のイメージで初期化
		canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'source-atop';//転写時の合成モード
		canvas[activelayer_num-1].getContext("2d").globalAlpha = opacity/100; //転写時の透明度
		canvas[activelayer_num-1].getContext("2d").drawImage(activelayer, 0, 0);//アクティブレイヤーを転写
		}

		}
/*-----------------------------消しゴム-----------------------------------*/

		else if(getEraser){
	
	    $(activelayer).css("opacity",0);
	    


            context.globalAlpha = 1;
	    
            context.beginPath();
            //context.globalCompositeOperation = 'destination-out';
            context.strokeStyle = "#000000";
            context.lineWidth = width;
            context.lineJoin= 'round';
            context.lineCap = 'round';
            context.shadowBlur = 0;	   
            context.setTransform(1, 0, 0, 1, 0, 0);
            context.moveTo(startX, startY);
            context.lineTo(endX, endY);
            context.stroke();
            context.closePath();


		canvas[activelayer_num-1].getContext("2d").putImageData(lines[lines.length-1],0,0);//転写レイヤーを描画前のイメージで初期化
		canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'destination-out';//転写時の合成モード
		canvas[activelayer_num-1].getContext("2d").globalAlpha = opacity/100; //転写時の透明度
		canvas[activelayer_num-1].getContext("2d").drawImage(activelayer, 0, 0);//アクティブレイヤーを転写
		
	}
      
/*-------------------------------------濃淡消しゴム-----------------------------------*/

	else if(getairEraser){

		
	
	    $(activelayer).css("opacity",0);

             context.globalAlpha = 1;
		
            context.beginPath();
            //context.globalCompositeOperation = 'destination-out';
            context.strokeStyle = "#000000";
            context.lineWidth = width;
            context.lineJoin= 'round';
            context.lineCap = 'round';
            context.shadowBlur = width;
	    context.shadowColor = "#000000";
            context.setTransform(1, 0, 0, 1, 0, 0);
            context.moveTo(startX, startY);
            context.lineTo(endX, endY);
            context.stroke();
            context.closePath();


		canvas[activelayer_num-1].getContext("2d").putImageData(lines[lines.length-1],0,0);//転写レイヤーを描画前のイメージで初期化
		canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'destination-out';//転写時の合成モード
		canvas[activelayer_num-1].getContext("2d").globalAlpha = opacity/100; //転写時の透明度
		canvas[activelayer_num-1].getContext("2d").drawImage(activelayer, 0, 0);//アクティブレイヤーを転写
		
	}
       
		startX=endX;
		startY=endY;


		});
/*--------------------レイヤー転写処理-------------------------*/


 	$("canvas").live('mouseup', function() {
        	
	if(getEffectbrush)
	clearInterval(effect);
	if(!getEffectbrush && !getEraser && !getairEraser && !$("#lock").attr("checked")){　//透明度保護のチェックがない場合のブラシ選択時の処理(エフェクトブラシは除く)
	canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'source-over';
	canvas[activelayer_num-1].getContext("2d").globalAlpha = opacity/100;
	canvas[activelayer_num-1].getContext("2d").drawImage(activelayer, 0, 0);
	
  	$(activelayer).clearCanvas();
	
  	


		}
	else if(getEraser || getairEraser ||  $("#lock").attr("checked") && !getEffectbrush){    //透明度の保護ON時、または、消しゴム選択時の処理(エフェクトブラシは除く)
	canvas[activelayer_num-1].getContext("2d").globalCompositeOperation = 'source-over';//念のため
	$(activelayer).clearCanvas();
	$(activelayer).css("opacity",opacity/100);

	}

	isDrawing = false;

    	});
/*-------------------マウスリーブ----------------------*/

 
    	$("canvas").live('mouseleave', function() {
        	if(getEffectbrush)
		clearInterval(effect);
		isDrawing = false;
    	});

/*----------------ショートカット----------------------*/

	shortcut.add("Alt",function(){
 
	$("#spuit").attr("checked","true");
		},{
		"type":"keydown",
		'disable_in_input':true,
		'keycode':18

	});

	shortcut.add("Alt",function(){
 
		$("#brush").attr("checked","true");
		},{
		"type":"keyup",
		'disable_in_input':true,
		'keycode':18

	});

	shortcut.add("b",function(){
 
	$("#brush").attr("checked","true");
	},{
	"type":"keydown",
	'disable_in_input':true,
	'keycode':66
	});


	shortcut.add("Ctrl+z",function(){ //undo
 
			if(lines.length >0){
			
		canvas[activelayer_num-1].getContext("2d").putImageData(lines[lines.length-1],0,0);
		lines.pop();
	}
	
	});

	$("#colorpicker").mouseup(function(){ //色取得
		color=$.farbtastic(this).color;
		});

/*-----------------------------画像の保存----------------------------------*/

	$("#saveButton").click(function(){
		
		for(var i=eyes.length-1; i>=0; i--){
		if(eyes[i].checked){
		frontlayer.getContext("2d").globalCompositeOperation = 'source-over';
		frontlayer.getContext("2d").drawImage(canvas[(eyes.length-1-i)*2], 0, 0);
			}

		}

		Canvas2Image.saveAsPNG(frontlayer);
		$(frontlayer).clearCanvas();
		
		});


function drawAll(){	// すべての線を描画
	$("#myCanvas").clearCanvas();
	for(i =0; i< lines.length; i++){
		var line = lines[i];
		var lineColor =line.color;
		var lineWidth =line.width;
		for(j =0; j<line.points.length-1; j++){

			point1=line.points[j];
			point2=line.points[j+1];

			$("#myCanvas").drawLine({
				strokeStyle: lineColor,
				strokeWidth: lineWidth,
				strokeCap:"round",

				x1:point1.x, y1:point1.y,
				x2:point2.x, y2:point2.y
			});
		}
	}

}

/*----------------------Draw関数---------------------------------*/

function Draw() {

	
  	ctx.globalCompositeOperation = "lighter";
		
		var grad  = ctx.createRadialGradient(startX, startY, 0, startX, startY, width);
		
		var rgbacolor = color;
		
		rgbacolor.replace("rgb","rgba");
		rgbacolor.replace(")",",1)");


		//グラデーションの色と透明度指定　0が開始地点、１が終了地点
    		grad.addColorStop(0, rgbacolor);
	
    		grad.addColorStop(1, "rgba(0, 0, 0, 0)");
	    
            ctx.beginPath();
            ctx.strokeStyle = grad;
            ctx.lineWidth = width*2;
            ctx.lineJoin= 'round';
            ctx.lineCap = 'round';
            ctx.shadowBlur = 0;
            ctx.setTransform(1, 0, 0, 1, 0, 0);
	　　
            ctx.moveTo(startX, startY);
            
	if( startX==endX && startY==endY){
		ctx.lineTo(endX+1, endY+1);
	}
	else	ctx.lineTo(endX, endY);
            


	    ctx.stroke();
            ctx.closePath();

		startX=endX;
		startY=endY;
		


};
