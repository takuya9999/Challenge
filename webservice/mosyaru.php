<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Blank Template for Bootstrap</title>
        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="style.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <script type="text/javascript" src="paint/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="paint/jquery-ui-1.9.0.custom.min.js"></script>
        <script type="text/javascript" src="paint/processing-1.4.1.min.js"></script>
        <script type="text/javascript" src="paint/jcanvas.min.js"></script>
        <script type="text/javascript" src="paint/shortcut.js"></script>
        <script type="text/javascript" src="paint/farbtastic.js"></script>
        <script type="text/javascript" src="paint/rgbcolor.js"></script>
        <script type="text/javascript" src="paint/canvas2image.js"></script>
        <script type="text/javascript" src="paint/music.js"></script>
        <script type="text/javascript" src="paint/canvasLCD.js"></script>
        <script type="text/javascript" src="sdk.js"></script>
         <script type="text/javascript" src="mo_pinterest.js"></script>

        <script>
    window.pAsyncInit = function() {
        PDK.init({
            appId: PIN_APP, // Change this
            cookie: true
        });
    };

    (function(d, s, id){
        var js, pjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//assets.pinterest.com/sdk/sdk.js";
        pjs.parentNode.insertBefore(js, pjs);
    }(document, 'script', 'pinterest-jssdk'));
</script>
        <script type="text/javascript" src="paint/mosyaru.js"></script>

        <link rel="stylesheet" href="paint/farbtastic.css" type="text/css" />
        <link rel="stylesheet" href="paint/jquery-ui-1.9.0.custom.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    </head>
    <body class="">
        <div class="content">
            <div class="mosyaru-left">
                <h5 class="lefttitle">参考サイトを選択してください</h5>
                <div class="btn-group-vertical refimgbtn"> 
                    <button type="button" class="btn btn-default pbtn">
                        <i class="fa fa-pinterest-square fa-2x fa-fw text-left"></i>pinterest
                    </button>                     
                </div>
                <form role="form" class="pixivform"> 
                    <div class="form-group"> 
                        <label class="control-label" for="exampleInputEmail1">PIXIV ID</label>                         
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="あなたのPIXIVID"> 
                    </div>                     
                    <div class="form-group"> 
                        <label class="control-label" for="exampleInputPassword1">パスワード</label>                         
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="パスワード"> 
                    </div>                     
                    <div class="form-group"> 
                        <p class="help-block">参考画像にあなたのpixivお気に入りユーザーを使用できます。</p> 
                    </div>                     
                    <div class="checkbox"> 
                        <label class="control-label"> 
                            <input type="checkbox"> ログイン状態を保存する                       
                        </label>                         
                    </div>                     
                    <button type="submit" class="btn btn-info" onClick="PDK.login({ scope :PIN_SCOPE },PDK.getSession())">ログイン</button>                     
                </form>
                <div class="toolbox" id="toolbox">
                    <div id="tool"> 
                        <div id="colorbox"> 
                            <div id="colorpicker"> 
</div>                             
                            <form>
                                <input type="text" id="color" name="color" value="#123456" />
                            </form>                             
                        </div>                         
                        <div id="point" widrh="100" height="50" bgcolor="#ccc"> 
                            x:0,y:0 	
</div>                         
                        <form autocomplete="off" id="formbox"> 
                            <br> 
                            <label>
                                <input type="radio" name="brush" id="brush" checked>Brush
                            </label>                             
                            <label>
                                <input type="radio" name="brush" id="airbrush">AirBrush
                            </label>                             
                            <label>
                                <input type="radio" name="brush" id="lighterbrush">LighterBrush
                            </label>
                            <br> 
                            <label>
                                <input type="radio" name="brush" id="Eraser">Eraser
                            </label>                             
                            <label>
                                <input type="radio" name="brush" id="airEraser">AirEraser
                            </label>                             
                            <label>
                                <input type="radio" name="brush" id="spuit" />Spuit
                            </label>
                            <br> 
                            <input type="button" id="fillbutton" value="FillCanvas">
                            <input type="button" id="fillopacitybutton" value="FillTranslucent"> 
                            <div id="bwbox"> 
                                BrushWidth&nbsp;
                                <input type="text" id="bw" value="10" readonly="readonly" /> 
                                <div id="widthslider"></div>                                 
                            </div>                             
                            <div id="opbox"> 
                                BrushOpacity&nbsp;
                                <input type="text" id="op" value="100" readonly="readonly" /> 
                                <div id="opacityslider"></div>                                 
                            </div>                             
                            <input type="button" id="clearButton" value="Clear"> 
                            <input type="button" id="undoButton" value="Undo"> 
                            <input type="button" id="saveButton" value="SaveImage"> 
                        </form>                         
                    </div>
                    <div id="layerbox" style="float:left;" class=""> 
                        <form class=""> 
                            <fieldset id="speaker" style="border:none;" class=""> 
                                <label>
                                    <input type="checkbox" name="brush" id="lock" />LockOpacity
                                </label>                                 
                            </filedset>                             
                            <fieldset id="addlayer"> 
                                <label>
                                    <input type="button" id="addlayerbutton" value="+">
                                </label>
                                <label>
                                    <input type="button" id="removelayerbutton" value="－">
                                </label>                                 
                                <label>
                                    <input type="button" id="upbutton" value="↑">
                                </label>
                                <label>
                                    <input type="button" id="downbutton" value="↓">
                                    <br> 
                                    <label>
                                        <input type="button" id="composite" value="Composite">
                                    </label>
                                    <label>
                                        <input type="button" id="copy" value="Copy">
                                    </label>
                                    <br> 
                                </filedset>                                 
                                <fieldset id="activeLayerPalette"> 
                                    <span>Layer<br></span> 
                                    <div id="layerArea"> 
                                        <span><input type="checkbox" name="visibleLayer" id="visibleLayer3" checked><label>
                                                <input type="radio" name="selectLayer" hecked>layer1
                                                <br>
                                            </label></span> 
                                    </div>                                     
                                </fieldset>                                 
                        </form>                         
                    </div>
                </div>
            </div>
            <div class="top-right">
                <header class="header"></header>
                <div class="reference pull-left">
                    <input type="text" class="form-control refform" placeholder="参考画像のURLを入力、または画像をドロップしてください">
                    <div class="pull-left referenceimg">
</div>
                    <div class="pixiv" id="pinterest">
                        <script type="text/javascript">
                        // PDK.me();
                        </script>


                    </div>
                </div>
                <div class="reference pull-left">
                    <div class="btn-group"> 
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-repeat"></span>undo
                        </button>
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-refresh"></span>リセット
                        </button>
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-upload"></span>投稿
                        </button>
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-pause"></span>一時停止
                        </button>
                    </div>
                    <div class="pull-left canvasimg">
</div>
                </div>                 
            </div>
        </div>
        <!-- Bootstrap core JavaScript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
        <script type="text/javascript">
    PDK.login

        </script>
    </body>
</html>
