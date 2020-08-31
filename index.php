<?php
if (!file_exists("install.lock")) {
    header("Refresh:0;url=\"./install.php\"");
    exit("正在跳轉至安裝介面...");
}
//检测是否已经安装
require_once "header.php";
require_once "config.php";
//开始判断处理
if ($status == "undefind" || empty($status)) {
?>
  <br/><center><br/><img src="https://3gimg.qq.com/tele_safe/safeurl/img/notice.png" widht="85"  height="85" alt="錯誤"></center>
  <center><h2>您訪問的頁面不存在!</h2></center>
<?php
    require_once "footer.php";
    exit();
}
if ($status == "passmessage") {
    //如果数据库type读取为密语 
?>
      <br />
      <div class="mdui-card.mdui-card-media-covered-transparent">
        <div class="mdui-card-primary">
          <div class="mdui-card-primary-subtitle"><?php echo $timemessage?></div>
            <center>
              <div class="mdui-card-primary-title" style="word-break:break-all;">
                「<?php echo htmlspecialchars($information)?>」
              </div>
            </center>
          </div>
        </div>
      </div>
    <br/>
    <div class="mdui-card.mdui-card-media-covered-transparent">
    <br />
    <h4>&emsp;&emsp;Q:這是什麼?</h4>
    <h5>&emsp;&emsp;A:這是別人傳送給你的密語!</h5><br/>
    <h4>&emsp;&emsp;Q:我要如何填寫密語?</h4>
    <h5>&emsp;&emsp;A:前往<a class="mdui-text-color-grey-800" href="<?php echo " ". $url?>"><?php echo $url?></a> 網頁填寫密語</h5>
    <br />
    </div>
<?php
      require_once "footer.php";
      exit();
    }
    //至此显示密语结束
    //因为为了解决速度问题，所以url的跳转放置显示css直之前，即header.php开头部分  
    unset($_SESSION['shorturl']);  //删除shorturl的session submit里面跳转到shorturl.php的那个session
    //unset($_SESSION['passwd']); //删除上一次的短域session
?>
<br/>
<div class="mdui-container doc-container">
    <div class="mdui-typo">
        <h2>短網址</h2>
        <div class="mdui-textfield">
            <textarea id="content" class="mdui-textfield-input" type="text" placeholder="*請輸入要縮短的網址或密語"></textarea>
        </div>
        <div style="float: left; width: 49.2%;" class="mdui-textfield">
            <input id="shorturl" class="mdui-textfield-input" type="text" placeholder="請輸入自定義短網址(選填)"/>
        </div>
        <div style="float: right; width: 49.2%;" class="mdui-textfield">
            <input id="passwd" class="mdui-textfield-input" type="text" placeholder="請輸入加密密碼(選填)"/>
        </div>
        
        <button onClick="submit();" id="submit" class="mdui-btn mdui-btn-dense mdui-color-theme-accent mdui-ripple">
          <i class="mdui-icon material-icons">send</i>
        </button>
        <label class="mdui-radio">
          <input onclick='change("shorturl")' type="radio" name="type" id="type"  value="shorturl" checked />
          <i class="mdui-radio-icon"></i>短網址
        </label>
        &emsp;&emsp;
        <label class="mdui-radio">
          <input onclick='change("passmessage")' type="radio" name="type" id="type"  value="passmessage" />
          <i class="mdui-radio-icon"></i>密語
        </label>
    </div>
</div>
<script>
var $ = mdui.JQ;

function change(type)
{
  if(type == 'shorturl')
  {
    $('#content').removeAttr('rows');
    $('#content').removeAttr('cols');
  }else{
    $('#content').attr('rows','10');
    $('#content').attr('cols','10');
  }
}

function submit(){
  type = $('input[name="type"]:checked').val();
  content = $('#content').val();
  shorturl = $('#shorturl').val();
  passwd = $('#passwd').val();
  $('#submit').attr('disabled',true)
  $('#submit').text('處理中...')
  $.ajax({
    method: 'post',
    timeout: 10000,
    url: 'submit.php',
    data: {
      type: type,
      content: content,
      shorturl: shorturl,
      passwd: passwd
    },
    success: function(data)
    {
      if(data == 200)
      {
        mdui.snackbar({
         message: '縮短成功!',
         position: 'right-top',
         timeout: 0
       });
       window.setTimeout("window.location='shorturl.php'",2000);
      }else{
        mdui.snackbar({
         message: '縮短失敗: <br/>錯誤訊息: ' + data,
         position: 'right-top'
       });
      }
    },
    complete: function(xhr,textStatus) 
    {
      $('#submit').html('<i class="mdui-icon material-icons">send</i>')
      $('#submit').removeAttr('disabled');
      if(textStatus == 'timeout')
      {
        mdui.snackbar({
         message: '請求超時!',
         position: 'right-top'
       });
      }
    }
  });
}

</script>
<div class="mdui-container doc-container">
    <div class="mdui-typo">
         <h2>幫助</h2>
         1.輸入短網址時請加上http(s)://<br />
         2.中文網址請使用Punycode編碼後再使用<br />
         3.網址最長支援1000字符<br />
         4.密語最長支援3000字符(大約1000漢字)<br />
         5.自訂短網址 Or 密码(選填)<br />
         6.密碼限制2-20位(英數組合)/短網址限制輸入<?php echo $pass ?>位<br/>
         7.其餘詳見菜單-幫助頁面
    </div>
</div>
<?php require_once "footer.php"; ?>
