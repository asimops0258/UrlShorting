<?php require_once("./header.php");?>
<title>偏好設定 - 星辰短網址|密語</title>
<div class="mdui-container">
  <div class="mdui-typo">
    <h2 class="doc-chapter-title doc-chapter-title-first">偏好設定</h2>
    <!-- 防红设置 -->
    <div class="mdui-container">
      <div class="mdui-typo">
        <h4 class="doc-chapter-title doc-chapter-title-first">防紅設定</h4>
        <ul class="mdui-list">
          <li class="mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">chat</i>
            <div class="mdui-list-item-content">
              微信
            </div>
            <label class="mdui-switch mdui-valign">
              <input id="wechat" onclick="switchx('wechat')" type="checkbox" />
              <i class="mdui-switch-icon"></i>
            </label>
          </li>
          <li class="mdui-list-item mdui-ripple"> <i class="mdui-list-item-icon mdui-icon material-icons">chat_bubble_outline</i>
            <div class="mdui-list-item-content">
              QQ
            </div>
            <label class="mdui-switch mdui-valign">
              <input id="QQ" onclick="switchx('QQ')" type="checkbox" />
              <i class="mdui-switch-icon"></i>
            </label>
          </li>
        </ul>
      </div>
    </div>
    <!-- 跳转设置 -->
    <div class="mdui-container">
      <div class="mdui-typo">
        <h4 class="doc-chapter-title doc-chapter-title-first">跳轉設定</h4>
        <ul class="mdui-list">
          <li class="mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">rotate_90_degrees_ccw</i>
            <div class="mdui-list-item-content">
              跳轉停留
            </div>
            <label class="mdui-switch mdui-valign">
              <input id="jump" onclick="switchx('jump')" type="checkbox" />
              <i class="mdui-switch-icon"></i>
            </label>
          </li>
          <li class="mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">gavel</i>
            <div class="mdui-list-item-content">
              網址檢測
            </div>
            <label class="mdui-switch mdui-valign">
              <input id="urlcheck" onclick="switchx('urlcheck')" type="checkbox" />
              <i class="mdui-switch-icon"></i>
            </label>
          </li>
        </ul>
      </div>
    </div>
</div>
</div>
<div class="mdui-container">
    <div class="mdui-typo">
      <h2 class="doc-chapter-title doc-chapter-title-first">提示訊息</h2>
      &emsp;1.防紅設定：在指定App打開時提示是否需要在瀏覽器開啟網頁<br/>
      &emsp;2.跳轉停留：用戶瀏覽短網址時是否顯示跳轉停留頁面<br/>
      &emsp;3.網址檢測：用戶瀏覽短網址時檢測該網址的安全性(需開啟跳轉停留)<br/>
    </div>
</div>
<br />
<?php 
//计划加功能：access  和 //wq刚想到，就忘记了。。
  function getResult($conn,$type)
  {
    $retun = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `config` WHERE `type` = '$type'")); 
    return $retun['content'] == "true" ? true:false; 
  }
?>
<script>
var $ = mdui.JQ;
function switchx(type) {
    $('#' + type + '').attr("disabled", true);
    //使按钮禁用,防止多次点击
    var x = $('#' + type + '').is(':checked', true);
    //console.log(type + "=>" + x);
    //调试
    $.ajax({
    method: 'GET',
    timeout: 10000, //10 secondes timeout
    url: '../app/preferences.php',
    data: {
        method: 'set',
        content: type,
        status: x?true:false,
        password: '<?php echo md5($password) ?>'
    },
    success: function(data) {
      $('#' + type + '').removeAttr('disabled')
        mdui.snackbar({
         message: '操作成功!',
         position: 'right-top'
       });
        if(type == 'jump')
        {
          if(x?true:false){
            $('#urlcheck').removeAttr("disabled");
          }else{
            $('#urlcheck').attr("disabled", true);
          }
        }
    },
    complete: function (xhr, textStatus) 
    {
       $('#' + type + '').removeAttr('disabled')
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
//后台获取数据
        //console.log(QQ+'  '+wechat)
        $('#QQ').prop('checked', <?php echo getResult($conn,"QQ") ?>);
        $('#wechat').prop('checked', <?php echo getResult($conn,"wechat"); ?>);
        $('#jump').prop('checked', <?php echo getResult($conn,"jump") ?>);
        //必须打开跳转停留
        if("<?php echo getResult($conn,"jump") ?>"==""?true:false)
        {
          $('#urlcheck').prop('checked', <?php echo getResult($conn,"urlcheck") ?>); 
          $('#urlcheck').attr("disabled", true);
        }else{
          $('#urlcheck').prop('checked', <?php echo getResult($conn,"urlcheck") ?>); 
        }
</script>
<?php require_once("../footer.php");
?>
