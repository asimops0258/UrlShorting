<?php require_once "header.php"; ?>
<title>後台首頁 - 星辰短網址|密語</title>
<div style="Height:20px"></div>
<div class="mdui-container">
  <h2 style="font-weight:400">官方訊息</h2>
  <ul class="mdui-list">
    <li id="officalInfo" style="font-weight:400" class="mdui-list-item mdui-ripple">Loading...</li>
  </ul>
</div>
</div>
<div class="mdui-container">
  <h2 style="font-weight:400">伺服器訊息</h2>
  <ul class="mdui-list">
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">grain</i>
      <div class="mdui-list-item-content">
        短網址總計: <?php getNum($conns,'information') ?>個
      </div>
    </li>
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">not_interested</i>
      <div class="mdui-list-item-content">
        已封鎖: <?php getNum($conns,'ban') ?>個
      </div>
    </li>
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">panorama_vertical</i>
      <div class="mdui-list-item-content">
        PHP版本: <?PHP echo PHP_VERSION; ?>
      </div>
    </li>
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">airplay</i>
      <div class="mdui-list-item-content">
        系統版本: <?PHP echo php_uname('s'); ?>
      </div>
    </li>
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">web</i>
      <div class="mdui-list-item-content">
        網頁伺服器版本: <?PHP echo $_SERVER['SERVER_SOFTWARE']; ?>
      </div>
    </li>
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">dns</i>
      <div class="mdui-list-item-content">
        主機名稱: <?PHP echo php_uname('n');  ?>
      </div>
    </li>
  </ul>
</div>
<?php
function getNum($conns,$tablename){
    echo mysqli_fetch_assoc(mysqli_query($conns,"select * from `TABLES` where `TABLE_NAME`='$tablename'"))['TABLE_ROWS'];
}
?>
<script>
var $ = mdui.JQ;
$.ajax({
  method: 'get',
  url: 'https://xsot.cn/api/update/notice.php',
  timeout: 10000,
  data: {
    app: 'urlshorting'
  },
  success: function(data)
  {
    data = eval('(' + data + ')');
    //console.log(data)
    len = Object.keys(data).length;
    len = len > 5 ? 5 : len;
    //console.log(len)
    //console.log(data['0']['content'])
    html = '';
    for(i = 0;i <= len-1;i++)
    {
      content = data[i]['content'];
      url = data[i]['url'];
      date = data[i]['date'];
      if(date == '')
      {
        info = content
      }else{
        info = date + ' | ' + content;
      }
      html += '\
      <li class="mdui-list-item mdui-ripple">\
        <div class="mdui-list-item-content" onclick="window.open(\'' + url + '\')">\
          ' + info + '\
        </div>\
      </li>';
    }
    //console.log(html)
    $('#officalInfo').replaceWith(html);
  },
  complete: function (xhr, textStatus) 
    {
      if(textStatus == 'timeout')
      {
        $('#officalInfo').replaceWith('<li class="mdui-list-item mdui-ripple"><div class="mdui-list-item-content">请求超时...</div></li>');
      }
    }
});
</script>
<?php require_once "../footer.php";  ?>
