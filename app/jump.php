<?php 
  require_once "app/getMaindomain.php";
  require_once "config.php";
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/css/mdui.min.css">
        <script src="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/js/mdui.min.js"></script>
        <title>
            <?php echo $title;?>
        </title>
    </head>
    <body>
    <div style="Height:40px"></div>
    <div class="mdui-container" style="max-width: 400px;">
        <div class="mdui-card">
                <div class="mdui-card-menu">
                    <button onclick="window.location.href='/'" class="mdui-btn mdui-btn-icon mdui-text-color-grey"><i class="mdui-icon material-icons">home</i>
                    </button>
                </div>
            <div class="mdui-card-primary">
                <div class="mdui-card-primary-title"><?php echo getTopHost($information) ?></div>
                <div class="mdui-card-primary-subtitle" id="safeInfo">安全性未知</div>
            </div>
            <div class="mdui-card-content">即將跳轉至:&nbsp;
                <div class="mdui-chip"><span class="mdui-chip-title" id="url"></span>
                </div>
                <br>
            </div>
            <div class="mdui-card-actions">
                <center>
                    <button id="btn" onclick="jump()" class="mdui-btn mdui-ripple mdui-btn-dense">立即前往</button>
                </center>
            </div>
        </div>
    </div>
    <div style="Height:20px"></div>
    <div class="mdui-container" style="max-width: 400px; display: none" id="urlCheckPage">
    <div class="mdui-card">
        <div class="mdui-card-primary">
            <div class="mdui-card-primary-title" id="safeInfo_2">詳細資訊</div>
            <div class="mdui-card-primary-subtitle" id="safeInfo">資料來源: 騰訊網址安全中心</div>
        </div>
        <ul class="mdui-list">
            <li class="mdui-list-item mdui-ripple">
                <div class="mdui-list-item-content">
                    <div class="mdui-list-item-title">是否備案: 
                      <span id="beian">Loading...</span>
                    </div>
                </div>
            </li>
            <li id="icporg_li" class="mdui-list-item mdui-ripple">
                <div class="mdui-list-item-content">
                    <div class="mdui-list-item-title">備案主體: 
                        <span id="icporg">Loading...</span>
                    </div>
                </div>
            </li>
            <li id="icpdode_li" class="mdui-list-item mdui-ripple">
                <div class="mdui-list-item-content">
                    <div class="mdui-list-item-title">備案號: 
                        <span id="icpdode">Loading...</span>
                    </div>
                </div>
            </li>
            <li id="wordtit_li" class="mdui-list-item mdui-ripple">
                <div class="mdui-list-item-content">
                    <div class="mdui-list-item-title">報毒原因標題: 
                        <span id="wordtit">Loading...</span>
                    </div>
                </div>
            </li>
            <li id="word_li" class="mdui-list-item mdui-ripple">
                <div class="mdui-list-item-content">
                    <div class="mdui-list-item-title">報毒原因: 
                        <span id="word">Loading...</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
    <script>
    console.log("\n %c 星辰短網址|密語 %c Powered by XCSOFT | xsot.cn ","color:#444;background:#eee;padding:5px 0;", "color:#eee;background:#444;padding:5px 0;");
    var $ = mdui.JQ;
	  $('#url').html(str_split('<?php echo $information ?>','32'))
  	function str_split(string, len){
		var new_string = "";
		if (string.length > len) {
		  //处理过长的链接
			new_string = string.substring(0, len);
  		new_string += "..."
		}
		else {
			new_string = string;
		}
		  return new_string;
	  }
	  
	  function jump()
	  {
	    //立即跳转
	    window.location.href='<?php echo $information ?>';
	  }
	  
	  function safeChange(beian,icporg,icpdode,wordtit,word)
	  {
	    //安全信息修改
	    if(beian == "1")
	    {
	      $('#beian').replaceWith('<span>是</span>');
	      if(icporg !== "")
	      {
	        $('#icporg').replaceWith('<span>' + icporg + '</span>');
	      }else{
	        $('#icporg_li').css('display','none')
	      }
	      if(icpdode !=="")
	      {
	        $('#icpdode').replaceWith('<span>' + icpdode + '</span>');
	      }else{
          $('#icpdode_li').css('display','none')
	       }
	    }else{
	      $('#beian').replaceWith('<span>否</span>');
	      $('#icporg_li').css('display','none')
	      $('#icpdode_li').css('display','none')
	    }
	    if(wordtit !== "")
	    {
	      $('#wordtit').replaceWith('<span>' + wordtit + '</span>');
	    }else{
	      $('#wordtit_li').css('display','none')
	    }
	    if(word !== "")
	    {
	      $('#word').replaceWith('<span>' + word + '</span>');
	    }else{
	      $('#word_li').css('display','none')
	    }
	   }
	  
	  if ("<?php echo getResult($conn,"urlcheck ") ?>"==""?false:true) {
    //检测是否开启了网址安全检测
    $('#safeInfo').replaceWith('<div class="mdui-card-primary-subtitle" id="safeInfo">網頁安全檢查中...</div>');
    $('#btn').replaceWith('<button id="btn" onclick="jump()" class="mdui-btn mdui-ripple mdui-btn-dense">網頁安全檢查中...</button>')
    //构建ajax请求
    $.ajax({
        method: 'POST',
        url: './app/urlsafe.php',
        data: {
            u: '<?php echo $information ?>'
        },
        success: function(data) {
          data =  eval('(' + data + ')');
          if(data['type'] == 3)
          {
            $('#safeInfo').replaceWith('<div class="mdui-card-primary-subtitle" id="safeInfo">此網頁很安全,請安心瀏覽!</div>');
            $('#btn').replaceWith('<button onclick="jump()" class="mdui-btn mdui-ripple mdui-btn-dense">轉跳中...</button>');
            window.setTimeout("window.location='<?php echo $information ?>'", 3000);
          }else if(data['type'] == 2)
          {
            $('#safeInfo').replaceWith('<div class="mdui-card-primary-subtitle" id="safeInfo">此網頁有危險,請謹慎瀏覽!</div>');
          }else{
            $('#safeInfo').replaceWith('<div class="mdui-card-primary-subtitle" id="safeInfo">安全性未知</div>');
            $('#btn').replaceWith('<button onclick="jump()" class="mdui-btn mdui-ripple mdui-btn-dense">轉跳中...</button>');
            window.setTimeout("window.location='<?php echo $information ?>'", 3000);
          }
          $('#urlCheckPage').css('display','block') //显示监测框
          $('#btn').replaceWith('<button id="btn" onclick="jump()" class="mdui-btn mdui-ripple mdui-btn-dense">立即前往</button>')
          safeChange(data['beian'],data['icporg'],data['icpdode'],data['wordtit'],data['word'])
        }
    });
} else {
    $('#btn').replaceWith('<button onclick="jump()" class="mdui-btn mdui-ripple mdui-btn-dense">轉跳中...</button>');
    window.setTimeout("window.location='<?php echo $information ?>'", 2000);
}
    </script>
    </body>
