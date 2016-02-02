
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
var animation;
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
var melodych=1;
var ch_num=[1,2,3,4,5,6,7,8,9,11,12,13,14,15,16];
var color_time=5000; 
var skey = 0;//キー(スケールのルート音)
var canvas_w ,canvas_h;
var picker;
var bitmap1;
var bitmap2;
var effect=false;
var canavs_scale=3;

/*---------------------------------------webmidilink-----------------------------------------------------------*/

function Synth() {
    this.lastNote = null;//フラグみたいなもの、どちらかというと、lastって名前だけど、どちらかというと現在のノート番号を表してると思う。新しいノート番号と比較して、違ったらノート番号を変更する役割
    this.lastCh=null;//これないとch変わった時noteofできない
    this.sy = null;
    this.Load = function(url) {
        this.sy = window.open(url, "sy1", "width=900,height=670,scrollbars=yes,resizable=yes");
    }
    this.NoteOn = function(ch,note, velo) {
        this.SendMessage(this.sy, "midi,9" + (ch-1).toString(16)+ "," + note.toString(16) + "," + velo.toString(16));
        if(ch!=10){
	this.lastNote = note;
	this.lastCh=ch;
	}
    }
    this.NoteOff = function(ch,note) {
        this.SendMessage(this.sy, "midi,8"+(ch-1).toString(16)+","+note.toString(16) + ",0");
    }
    this.LastNoteOff = function() {
        if (this.lastNote != null) this.NoteOff(this.lastCh,this.lastNote);//lastNoteに値が入っていれば、そのnote番号の音を止める　これ必要か？
        this.lastNote = null;//lastNoteを空にする
	this.lastCh=null;
    }
    this.GetLastNote = function() {
        return this.lastNote;
    }
    this.GetLastCh = function() {
        return this.lastCh;
    }
    this.AllSoundOff = function() {
        this.SendMessage(this.sy, "midi,b0,78,0");
    }
    this.SendMessage = function(sy, s) {
        if(this.sy)
            this.sy.postMessage(s, "*");
    }
}


/*----------------------------------synthlist----------------------------------------------------------*/

function SynthListCallback(synthlist) {
    var sel = document.getElementById("synthsel");
    for (var i = 0; i < synthlist.length; ++i) {
        sel.options[i] = new Option(synthlist[i].author+":"+synthlist[i].name, synthlist[i].url);
    }
}



function SetUrl(id, url) {
  var obj = document.getElementById(id);
  obj.value = url;
}


/*---------------------------------------------------pad-------------------------------------------------------------------*/

var synth = new Synth();
//var mouse = { x: null, y:null, b:false };//これって連想配列？それともオブジェクト？
var canvas, context, gridImage;
var grid = 10;
var beatTimer = null;



$(function(){
	
	
	var canvas =$("canvas");
	 canvas_w=canvas.attr("width");
	 canvas_h=canvas.attr("height");
	//window.alert(activelayer_num+"unko");
	layers =$("input[name='selectLayer']");//レイヤーボックスに表示されている全てのレイヤー要素
	eyes=$("input[name='visibleLayer']");//レイヤーボックスに表示されている全てのチェックボックス要素
	for(var i=0; i< layers.length; i++){
		if(layers[i].checked){
		checklayer_num = i;
		activelayer_num = (layers.length-(i+1))*2+1;
		
		}
	}

	
	//window.alert(activelayer_num+"unko");

	$("canvas.opacity").css("opacity",opacity/100);

	activelayer =canvas[activelayer_num];//	アクティブレイヤー(実際に描画処理をしているキャンバス。)

	frontlayer = canvas[canvas.length-1];
	context=$(activelayer).get(0).getContext('2d');//アクティブレイヤーのコンテクスト
	ctx=frontlayer.getContext("2d");

	
	

	picker = $.farbtastic('#colorpicker');//参照オブジェクト
	picker.linkTo($("#color")); //コールバックの設定、この場合、ロード時に"id=color"要素のテキストからcolor取得、イベント取得時に"id=color"のテキストと背景色を、取得したカラー情報(e)で上書きする。たぶん。
	color = $.farbtastic('#colorpicker').color;//初期カラー;この場合のcolorは参照オブジェクトなので、コールバックの度にcolorの値は動的に変化する
	picker.linkTo(function(e){melodych=ch_num[parseInt(e.replace("#",""),16)%15];
	//skey=parseInt(e.replace("#",""),16)%12;//key変更
	$("#color").val(e).css("background", e);color=e;});//引数eはcolor情報。コールバックの上書き。
	


//	var lcd = new CanvasLCD('01');
//	lcd.init("start", 'initialword', false);
//	lcd.write2Display('lettersRL01', 'ABCDEFG');
//	setTimeout(function(){lcd=null;$("#start").clearCanvas().css({"width":"","height":"","width":"600","height":"400"});},5000);


	 synth = new Synth();//Synthオブジェクト生成
	synth.Load('http://www.g200kg.com/webmidilink/gmplayer/');


/*---------------------------マウスイベント(重要)------------------------------------*/

  var bpmElem = document.getElementById('bpm');
  bpmElem.addEventListener("input", function(){SetBPM(this.value);});
  SetKey(0);
  SetBPM(120);
  SetScale([0,3,5,7,10]);

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

/*------------------------------エフェクトブラシのアニメーション-------------------------------------------------*/

	
	$("#effectbrush").change(function(){

		isanimation=true;
		animation = setInterval(function(){
			ctx.globalCompositeOperation = "source-over";//アニメーション
    			

			ctx.globalCompositeOperation = 'destination-out';
			ctx.fillStyle = "rgba(0, 0, 0, 0.05)";
    			ctx.fillRect(0, 0, $(activelayer).attr("width"), $(activelayer).attr("height"));
			},20);

			anime();
			$(canvas[activelayer_num-1]).css("visibility","hidden");

	});

/*--------------------ブラシ切り替え時のエフェクト停止処理-------------------------*/

	$("#brush").change(function(){
	if(isanimation){
		$("canvas")[$("canvas").length-1].remove();
		isanimation=false;
	}
//	if(effect){
//	clearInterval(effect);
//	effect=false;
//	window.alert(effect+"unko");
//	}
	clearInterval(animation);
	$(frontlayer).clearCanvas();
	$(canvas[activelayer_num-1]).css("visibility","visible");

	});


	$("#airbrush").change(function(){
	if(isanimation){
		$("canvas")[$("canvas").length-1].remove();
		isanimation=false;
	}


	clearInterval(animation);
	$(frontlayer).clearCanvas();
	$(canvas[activelayer_num-1]).css("visibility","visible");
	});



	$("#lighterbrush").change(function(){
	if(isanimation){
		$("canvas")[$("canvas").length-1].remove();
		isanimation=false;
	}


	clearInterval(animation);
	$(frontlayer).clearCanvas();
	$(canvas[activelayer_num-1]).css("visibility","visible");
	});

	$("#airEraser").change(function(){
	if(isanimation){
		$("canvas")[$("canvas").length-1].remove();
		isanimation=false;
	}


	clearInterval(animation);
	$(frontlayer).clearCanvas();
	$(canvas[activelayer_num-1]).css("visibility","visible");
	});

	$("#Eraser").change(function(){
	if(isanimation){
		$("canvas")[$("canvas").length-1].remove();
		isanimation=false;
	}

	clearInterval(animation);
	$(frontlayer).clearCanvas();
	$(canvas[activelayer_num-1]).css("visibility","visible");
	});

	$("#spuit").change(function(){
	if(isanimation){
		$("canvas")[$("canvas").length-1].remove();
		isanimation=false;
	}

	clearInterval(animation);
	$(frontlayer).clearCanvas();
	$(canvas[activelayer_num-1]).css("visibility","visible");
	});

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

/*--------------------カラータイマーイベント----------------------*/

	$("#c_timer").live("click",function(){
		
		if($("#c_timer").attr("checked")){
		 change_color = setInterval("color_timer()",color_time);
		}
		else clearInterval(change_color);
		
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

		// startX =e.clientX - offset.left-cursoroffset; //キャンバス内のx座標
		// startY =e.clientY - offset.top-cursoroffset;  //キャンバス内のy座標
		

		// startX =e.clientX - offset.left+(e.clientX - offset.left)-cursoroffset;
		// startY =e.clientY - offset.top+(e.clientY - offset.top)-cursoroffset;


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

		// endX =e.clientX - offset.left-cursoroffset;
		// endY =e.clientY - offset.top-cursoroffset;	


		// endX =e.clientX - offset.left+(e.clientX - offset.left)-cursoroffset;
		// endY =e.clientY - offset.top+(e.clientY - offset.top)-cursoroffset;



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
/*----------------------------以下、関数の定義------------------------------------*/

//var kick= synth.NoteOn(10,38,64);
var kick=36;
var clap=39;
var hat=42;
var snare=38;

var sscale = 0;//スケールの種類
function SetKey(k) {
  skey = parseInt(k);//プルダウンメニューから取得した文字列("0"とか)を整数変換。ちなみにメニューにはC:0ってな割り当てで設定されてる。
}

function SetBPM(bpm) {//bpmは1分間に何拍鳴るか(4分音符が何回鳴るか)という意味
  if (beatTimer) clearInterval(beatTimer);
  beatTimer = setInterval(Beat,60000/(bpm*8));//一拍(4分音符)にかかる秒数を8で割った秒数の間隔でbeatを実行
}

function SetScale(s) {
  sscale = s;//s:配列要素(例：[0,3,5,7,10])
}

var count = 0;
var clapcount=0;
//決まり事：NoteOnした状態でNoteOnしない。する場合は対応するNoteを一回NoteOffする必要がある。
//コード整理したいなぁ・・・
//リズムずれるからメロディーとドラムの順番変えてみる？
function Beat() {

  if(!$("#effectbrush").is(":checked"))
	return;	
  switch(count) {
    case 0: case 2: case 4: case 6://音を出すカウント,一拍(4分音符)のうち4回鳴ってる(4分の1÷4の16分音符)ので最大16ビート(※1小節は4分音符4つ。)
        synth.NoteOn(10,hat,64);
        if(count==0){ 
	synth.NoteOn(10,kick,64);
	if(clapcount==0){
		 zoom();
		rotate();
		}
		if(clapcount==8){
		  rotate();
		  synth.NoteOn(10,snare,64);
		　synth.NoteOn(10,clap,64);
		}
	}
	if (endY && isDrawing) {//mouseoverかつ、mousedownの時の条件式：endY=y座標値(mouseoutするとnullになる)、isDrawingはmousedown時のフラグ(mouseupするとfalse)
        var note = parseInt((canvas_h-endY)/grid)+48;//48("C3")～78("F5#")の値。(48+下から数えたy座標(0～300)/grid(10)の値,)
        var n = (note % 12);//n:0～11のいずれかの値、0は"C"(1オクターブ(12音)のいずれか)
	var n2 = 0;//スケールの修正値

        for(var i = 0; i < sscale.length; i++) {
          if (n >= sscale[i]) n2 = sscale[i];//スケールの修正。例：0,1,2の場合0、3,4の場合3、5,6の場合5、7,8,9の場合7、10,11の場合10
          else break;
        }

        note = parseInt(note/12)*12+n2+skey;//"C"に戻って、そこにスケール修正後の音階(n2)＋キーの変更(skey)をしたnote番号にする

        if (note != synth.GetLastNote()) {  //ノート番号が変わった時の処理
          synth.LastNoteOff();   //前のノート音をオフに
          synth.NoteOn(melodych,note, 64);   //ノート番号が変わったら、新しいノート番号の音を出す。
        }
      }//if (endY && isDrawing)ブロックの閉じかっこ

      else synth.LastNoteOff();//カーソルが画面外、またはクリックしてないときsynth.LastNoteOff()
      break;//case 0: case 2: case 4: case 6:の終了,Beatからbreak

    case 1: //音を切る役目。一つの単音を出すのにon,ofが必要だから一拍に4回音を出す(16分音符を作る)なら4×2で8個の条件分けが必要だったというわけ。
      synth.NoteOff(10,kick);
      synth.NoteOff(10,hat);
	if(clapcount==9){//この条件式必要ないかも
		synth.NoteOff(10,snare);
		synth.NoteOff(10,clap);
	}
	if(endX > parseInt(canvas_w/5)*4){
		synth.LastNoteOff();
	}
      break;

   case 3: case 7:
    
      synth.NoteOff(10,hat);

      if (endX > parseInt(canvas_w/5)&&count==7) {
        synth.LastNoteOff();
      }

      if (endX > parseInt(canvas_w/5)*2) { //else ifとどっちがいいんだろうか？
        synth.LastNoteOff();
      }
      break;

     case 5:
	synth.NoteOff(10,hat);
     if(endX > parseInt(canvas_w/5)*3) {
        synth.LastNoteOff();
      }
       break;

/*
    case 7://上に同じ。
      if (endX > parseInt(canvas_w/4)*3) {
        synth.LastNoteOff();
      }
      break;
*/
  }//switch文の閉じかっこ
  clapcount=(++clapcount) % 16;
  count = (++count) % 8;//カウント7で一拍分。8で割ってるのはsetInterval(Beat,60000/(bpm*8))のため。
}


/*----------カラータイマー--------------------*/
function color_timer(){

	var color= new Array(3);
	for(var i=0; i<3; i++){
		color[i]=Math.floor(256*Math.random());
	}

	var timer_color = new RGBColor('rgb(' + color[0] +','+color[1]+ ',' +color[2]+')');
	picker.setColor(timer_color.toHex());
	//color =picker.color;
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
			
  
}
var rotate;
var zoom;

function anime(){
     //var canvas = document.getElementById(frontlayer);
    //$(frontlayer).before('<canvas  width="600" height="400"></canvas>').clone(true);
     //var stage  = new createjs.Stage($("canvas")[$("canvas").length-2]);
	$("#canvasArea").append('<canvas  width="600" height="400"></canvas>').clone(true);
	var stage  = new createjs.Stage($("canvas")[$("canvas").length-1]);
    
//////////////////////////////////////////////////
 // Bitmapクラスのインスタンスを作成する。
      bitmap1 = new createjs.Bitmap($("canvas")[activelayer_num-1]);

     // 中心に描画する。
     bitmap1.regX = canvas_w/2;
     bitmap1.regY = canvas_h/2;
     bitmap1.x = canvas_w/2;
     bitmap1.y = canvas_h/2;
     bitmap1.alpha=0.3;
     // ステージに追加して、アニメーションを開始する。
     stage.addChild(bitmap1);
     createjs.Ticker.setFPS(30);
     createjs.Ticker.addListener(stage);

//////////////////////////////////////////////////


// Bitmapクラスのインスタンスを作成する。
      bitmap2 = new createjs.Bitmap($("canvas")[activelayer_num-1]);
	
     // 中心に描画する。
     bitmap2.regX = canvas_w/2;
     bitmap2.regY = canvas_h/2;
     bitmap2.x = canvas_w/2;
     bitmap2.y = canvas_h/2;
     bitmap2.alpha=0.2;
     // ステージに追加して、アニメーションを開始する。
     stage.addChild(bitmap2);
     createjs.Ticker.setFPS(30);
     createjs.Ticker.addListener(stage);
     // アニメーションを行う。
     	 zoom= function(){createjs.Tween.get(bitmap1, {loop:false})
          .to({alpha:0, scaleX:4, scaleY:4}, 500, createjs.Ease.sinInOut)
          .to({alpha:0.3, scaleX:1, scaleY:1});
          };//セミコロンあったほうがいい？

	  rotate= function(){createjs.Tween.get(bitmap2, {loop:false})
          .to({scaleX:-1}, 300, createjs.Ease.sinIn)
          .to({scaleX:1}, 300, createjs.Ease.sinIn);
	};//セミコロンあった方がいい？
};
