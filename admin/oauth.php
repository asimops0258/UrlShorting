<?php 
define('CLIENT_ID','8us3lhiuyiOlyT3KitpWvtIwGindm5');
define('CLIENT_SECRET','8us3lhiuyiOlyT3KitpWvtIwGindm5');
if(empty($_GET['code'])){
  require_once "header.php"; 
  $arr = explode(",",mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `config` WHERE type='xoauth'"))['content']);
  if(empty($arr[0]))
  {
    //防止数据为空的问题
    $arr = array();
  }
  $list = ''; //初始化列表
  for ($i = 0; $i <= count($arr)-1; $i++)
  {
    $user = $arr[$i];
    $list .= 
       "<li id='$user' class='mdui-list-item'>
          <i class='mdui-list-item-icon mdui-icon material-icons'>list</i>
          <div class='mdui-list-item-content'>
            <div class='mdui-list-item-title'>$user</div>
          </div>
          <span onclick=\"del('$user')\" class='mdui-btn mdui-btn-icon mdui-ripple' style='color:#808080'>
          <i class='mdui-icon material-icons'>close</i>
          </span>
        </li>";
  }
  if(empty($list))
  {
    $list = "<li class='mdui-list-item'>
          <div class='mdui-list-item-content'>
            <div class='mdui-list-item-title'>未找到授权记录</div>
          </div>
        </li>";
  }
  ?>
  <title>第三方登入 - 星辰短網址|密語</title>
  <div style="Height:20px"></div>
    <div class="mdui-container">
    <h2 style="font-weight:400">操作</h2>
      <ul class="mdui-list">
        <!-- 文档 -->
      <li onclick="window.location.href='<?php echo "http://oauth.xsot.cn/oauth.php?response_type=code&client_id=". CLIENT_ID ."&redirect_uri=".$url."admin/oauth.php" ?>'" class="mdui-list-item">
        <i class="mdui-list-item-icon mdui-icon material-icons">assessment</i>
        <div class="mdui-list-item-content">新增使用者</div>
      </li>
    </ul>
  </div>
  <div class="mdui-container">
  <h2 style="font-weight:400">第三方登入</h2>
  <p style='color:grey;font-size:15px;'>星辰oauth第三方授權登入列表</p>
    <ul class="mdui-list">
    <?php echo $list ?>
    </ul>
  </div>
  <!-- 加载 -->
  <div id='loading' style="position: absolute;margin: auto;top: 0;left: 0;right: 0;bottom: 0;display: none;width: 50px;height: 50px" class="mdui-spinner mdui-spinner-colorful"></div>
  
  <script>
  var $ = mdui.JQ
  
  function del(user)
  {
    mdui.confirm('您確定要取消授權嗎?', function(){
      del_go(user)
    });
  }
  
  function del_go(user){
    $.showOverlay(); //遮罩
    $('#loading').show();
    
    $.ajax({
        url: '../app/oauth_api.php',
        method: 'post',
        timeout: 10000,
        data: {
            method: 'del',
            user: user
        },
        success: function(data) {
            data = eval('(' + data + ')');
            if (data['code'] == '200') {
                mdui.snackbar({
                    message: '取消授權成功',
                    position: 'right-top',
                });
                setTimeout(function () {$('#' + user + '').remove();}, 100);  //jquery移除指定
            } else {
                mdui.snackbar({
                    message: '出現錯誤<br/>錯誤訊息:' + data['msg'],
                    position: 'right-top',
                });
            }
        },
        complete: function(xhr, textStatus) {
          setTimeout(function () {$.hideOverlay();}, 100); //隐藏遮罩
          $('#loading').hide();
            if (textStatus == 'timeout') {
                mdui.snackbar({
                    message: '請求超時!',
                    position: 'right-top',
                });
            } else if (textStatus !== 'success') {
                mdui.snackbar({
                    message: '出現未知錯誤,錯誤代碼:' + textStatus,
                    position: 'right-top',
                });
            }
        }
    });
  }
  

  </script>
<?php 
  require_once "../footer.php"; 
}else{
  require_once "../config.php";
  //如果处于添加模式(code不为空)
  $code = $_GET['code'];
  $url = 'https://oauth.xsot.cn/api/token.php?code='. $code . "&client_id=".CLIENT_ID.'&client_secret='.CLIENT_SECRET;
  //echo $url;
  $arr = json_decode(file_get_contents($url),true);
    //print_r($arr);
  if($arr['code'] == '200')
  {
    $url = 'https://oauth.xsot.cn/api/resourse.php?access_token=' . $arr['access_token'].'&client_secret='.CLIENT_SECRET;
    $return = json_decode(file_get_contents($url),true);
    $username = $return['username']; 
    $arr = explode(",",mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `config` WHERE type='xoauth'"))['content']);
    if(empty($arr[0]))
    {
      //防止数据为空的问题
      $arr = array();
    }
    if(array_search($username,$arr) !== false){
      //已有存在的用户
      header("Refresh:0;URL='./oauth.php'");
    } else {
      array_push($arr,$username);
      $str = implode(",",$arr);
      mysqli_query($conn,"UPDATE `config` SET `content`='$str' WHERE `type` = 'xoauth' ");
      header("Refresh:0;URL='./oauth.php'");
    }
  } else{
    echo "<h2>出現未知錯誤!錯誤代碼:" . $arr['code']."</h2>";
    header("Refresh:2;URL='./oauth.php'");
  }
}?>
