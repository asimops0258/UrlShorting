<?php
if(!file_exists("install.lock")){
header("Refresh:0;url=\"./install.php\"");
exit("正在跳轉至安裝介面...");
}else{
}
require_once('header.php');
echo <<<EOF
<br />
<div class="mdui">
    <!--<div class="mdui-col-sm-6 mdui-col-md-4">-->
      <div class="mdui-card">
        <div class="mdui-card-header">
          <img class="mdui-card-header-avatar" src="./assets/img/logo.png"/>
          <div class="mdui-card-header-title">星辰短網址|密語</div>
          <div class="mdui-card-header-subtitle">一款簡潔美觀的短網址平台|密語平台</div>
        </div>
        <div class="mdui-card-media">
          <img src="http://soxft.cn/assets/img/team.png"/>
        </div>
  <div class="mdui-card-content">
版本：$version<br/>
<br/>
作者：XCSOFT(XSOT.CN)<br/>
<br/>
使用語言(框架)：PHP HTML MDUI MYSQL<br/>
  </div>
  <div class="mdui-card-actions">
<a class="mdui-btn mdui-ripple" href="//blog.xsot.cn/archives/pro-URLshorting.html">官網</a>
<a class="mdui-btn mdui-ripple" href="//github.com/soxft/URLshorting">Github</a>
  </div>
</div>
EOF;
require_once('footer.php');
?>
