<?php
session_start();
require_once 'app/core.php';
require_once 'config.php';
//引入核心文件
$content = $_POST['content'];
$shorturl = $_POST['shorturl'];
$passwd = $_POST['passwd'];
$type = $_POST['type'];
//获取一大堆post
//如果用户选择了短域

$arr = Urlshorting($content, $type, $passwd, $shorturl);
if ($arr[0] == 200) {
    echo "200";
    $_SESSION['shorturl'] = $arr[1];
    $_SESSION['passwd'] = $arr[2];
} elseif ($arr[0] == 1001) {
    if ($type == 'shorturl') {
        echo "非法的URL";
    } else {
        echo "非法的密語";
    }
} elseif ($arr[0] == 1002) {
    echo "您輸入的域名或您的IP已被封鎖!";
} elseif($arr[0] == 3001 || $arr[0] == 3002) {
    echo "密碼只能為2-20位的英數標點組合";
}elseif($arr[0] == 2001 || $arr[0] == 2002) {
    echo "自訂義短網址只能為" . $pass . "位的英數組合";
}elseif($arr[0] == 2003) {
    echo "該自訂義短網址已被使用!";
}else{
    echo "error: " . $arr[0];
}

?>
