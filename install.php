<title>星辰安裝系統</title>
<body background="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/css/mdui.min.css">
  <script src="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/js/mdui.min.js"></script>
  <br />
  <center><h2>星辰網站安裝系統</h2></center>
  <?php
  $lockfile = "install.lock";
  if (file_exists($lockfile)) {
    exit("<center><h3>您已經安裝過了，如果需要重新安裝請先刪除跟目錄下的install.lock(如果您只需要修改内容請前往資料庫中修改config資料表表<br />如有任何疑問請加qq群：657529886)</center></h3>");
  }
  if (!isset($_POST['submit'])) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">資料庫伺服器位置</label>
        <input name="db_host" type="text" class="mdui-textfield-input" value="localhost" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">資料庫帳號名稱</label>
        <input name="db_username" type="text" class="mdui-textfield-input" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">資料庫名稱</label>
        <input name="db_name" type="text" class="mdui-textfield-input" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">資料庫密碼</label>
        <input name="db_password" type="password" class="mdui-textfield-input" />
      </div>
      <br />
      <br />
      <br />
      <hr><hr>
      <br />
      <br />
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">網站域名</label>
        <input name="url" type="text" class="mdui-textfield-input" value="http://<?php echo$_SERVER['HTTP_HOST'] ?>/" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">網頁標題(頁面)</label>
        <input name="title1" type="text" class="mdui-textfield-input" value="星辰短網址|密語" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">網頁標題(標籤)</label>
        <input name="title" type="text" class="mdui-textfield-input" value="星辰短網址|密語" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">自訂短網址後的英數長度</label>
        <input name="pass" type="text" class="mdui-textfield-input" value="4" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">管理後台密碼</label>
        <input name="passwd" type="text" class="mdui-textfield-input" value="admin" />
      </div>
      <br />
      <center>
        <input class="mdui-btn mdui-btn-raised mdui-ripple" type="submit" name="submit" value="安装" />
      </center>
      </form>
      <?php
    } else {
      if (empty($_POST['db_host']) || empty($_POST['db_username']) || empty($_POST['db_name']) || empty($_POST['db_password']) || empty($_POST['url']) || empty($_POST['title']) || empty($_POST['title1']) || empty($_POST['pass']) || empty($_POST['passwd'])) {
        exit("<br/><center><h1>請檢查是否有遺漏的內容，並重試!</h1></center>");
      } else {
        $db_host = $_POST['db_host'];
        $db_username = $_POST['db_username'];
        $db_password = $_POST['db_password'];
        $db_name = $_POST['db_name'];
        $url = $_POST['url'];
        $title = $_POST['title'];
        $title1 = $_POST['title1'];
        $pass = $_POST['pass'];
        $passwd = $_POST['passwd'];
      }
      $title = $title . " - Powered by XCSOFT";
      $conn = mysqli_connect($db_host,$db_username,$db_password,$db_name);
      if ($conn) {
      $banx = "CREATE TABLE ban (
        type varchar(10) NOT NULL,
        content	varchar(999) NOT NULL,
        time varchar(999) NOT NULL
      )";
      $informationx = "CREATE TABLE information(
        information	mediumtext NOT NULL,
        shorturl char(20)	NOT NULL,
        type char(20)	NOT NULL,
        passwd mediumtext NOT NULL,
        time char(20)	NOT NULL,
        ip char(20)	NOT NULL
      )";
      $config = "CREATE TABLE config(
        type mediumtext NOT NULL,
        content mediumtext	NOT NULL
      )";
      mysqli_query($conn,$banx);
      mysqli_query($conn,$informationx);
      mysqli_query($conn,$config);
      function configAdd($conn,$type,$content)
      {
        mysqli_query($conn,"INSERT INTO `config` VALUES('$type','$content')");
      }
      configAdd($conn,'url',$url);
      configAdd($conn,'title',$title);
      configAdd($conn,'title1',$title1);
      configAdd($conn,'pass',$pass);
      configAdd($conn,'strPolchoice',"123"); //url风格
      configAdd($conn,'passwd',$passwd);
      configAdd($conn,'wechat','true');
      configAdd($conn,'QQ','true');
      configAdd($conn,'jump','true');
      configAdd($conn,'urlcheck','true');
      configAdd($conn,'xoauth','');
      configAdd($conn,'px','25');
      configAdd($conn,'version','2.1.1');
      } else {
        exit("<br/><center><h1>連結資料庫失敗!請再次確認資料庫連結帳密及資料庫名稱!</h1></center>");
      }
      //写数据库
      $config_file = "config.php";
      $config_strings = "<?php\n";
      $config_strings .= "\$conn=mysqli_connect(\"".$db_host."\",\"".$db_username."\",\"".$db_password."\",\"".$db_name."\");\n";
      $config_strings .= "\$conns=mysqli_connect(\"".$db_host."\",\"".$db_username."\",\"".$db_password."\",\"information_schema\");\n//您的資料庫訊息\n";
      $config_strings .= "function content(\$info)\n";
      $config_strings .= "{\n";
      $config_strings .= "global \$conn;    //全局變量\n";
      $config_strings .= "\$comd = \"SELECT * FROM `config` where `type` = '\$info';\";\n";
      $config_strings .= "\$sql = mysqli_query(\$conn,\$comd);\n";
      $config_strings .= "\$arr = mysqli_fetch_assoc(\$sql);\n";
      $config_strings .= "return \$arr['content'];\n";
      $config_strings .= "}\n";
      $config_strings .= "\$url = content(\"url\");         \n//您網站的位置,不要忘記最後的'/'\n";
      $config_strings .= "\$title1 = content(\"title1\");   \n//網頁標題(頁面)\n";
      $config_strings .= "\$title = content(\"title\");   \n//網頁標題(標籤\n";
      $config_strings .= "\$pass = content(\"pass\");       \n//短網址後的英數字數,推薦4個以上,最長20!(請填寫數字)\n";
      $config_strings .= "\$strPolchoice = content(\"strPolchoice\");   \n//短網址包含的內容,(短網址後會出現的內容)\n";
      $config_strings .= "\$passwd = content(\"passwd\");   \n//設定後台管理密碼\n";
      $config_strings .= "\$px = content(\"px\");      \n//後台短網址管理頁面，單次顯示的短網址數量\n";
      $config_strings .= "\$version = content(\"version\");      \n//版本號--請不要修改\n";
      $config_strings.= "?>";
      //文件内容
      $fp = fopen($config_file,"wb");
      fwrite($fp,$config_strings);
      fclose($fp);
      //写config.php
      $fp2 = fopen($lockfile,'w');
      fwrite($fp2,'安裝鎖文件,請勿刪除!');
      fclose($fp2);
      //写注册锁
      echo "<br/><center><h1>安裝成功!4秒後將為您自動轉跳到後台登入介面!</h1></center>";
      echo "<br/><center><h1>您可進入後台編輯更多設定！</h1></center>";
      echo "<br/><center><h2>非寶塔一件部署用戶注意,您還需要自行手動設定偽靜態.往靜態設定訊息請參考根目錄下`README.md`中的內容.</h2></center>";
      header("Refresh:4;url=\"./admin/\"");
    }
    ?>
