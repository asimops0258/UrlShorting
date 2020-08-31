<html>
<head>
    <title>短網址管理 - 星辰短網址|密語</title>
    <?php
    require_once("./header.php");
    $p = $_GET['p'];
    if(empty($p) || $p < "1")
    {
      $p = "1";  //如果没有page那就定义一个默认的page  = 0
    }
    $page  = ($p - 1) * $px;
    //计算出第几条数据
  $mysql = "select * from `TABLES` where `TABLE_NAME`='information';";
  $result = mysqli_query($conns,$mysql);
  $arr = mysqli_fetch_assoc($result);
  $page_allx =  $arr['TABLE_ROWS'];  //所有数据
 if($page_allx >= $px)
 {
  if($page_allx % $px == 0){
    $page_all = $page_allx / $px; // 计算总共页数  
  }else{
    $page_all = ($page_allx - ($page_allx % $px)) / $px;
  }
 }else{
   $page_all = 1;
 }
    echo "<h4>提示訊息:因字符原因,表格顯示不完全,手機用戶可以想左滑動觀看更多訊息,電腦用戶可使用表格下端的控制條.</h4>";
    echo "<br /><center><div class=\"mdui-table-fluid\">
                        <table class=\"mdui-table mdui-table-hoverable\">
                            <tr>
                                <th>短網址</th>
                                <th>內容</th>
                                <th>種類</th>
                                <th>ip</th>
                                <th>密碼</th>
                                <th>時間</th>
                                <th>狀態</th>
                                <th>IP狀態</th>
                                <th>管理</th>
                            </tr>";
// 表格开头
  $comd = "SELECT * FROM `information` order by time DESC limit $page,$px";
    $sql = mysqli_query($conn,$comd);
    while ($row = mysqli_fetch_object($sql)) {
        $comd1 = "SELECT * FROM `ban` WHERE content='$row->shorturl'";
        $count1 = mysqli_query($conn,$comd1);
        $arr2 = mysqli_fetch_assoc($count1);
        $type = $arr2['type'];
        if (empty($type)) {
            $check = "正常";
        } else {
            $check = "BAN";
        }
        $comd2 = "SELECT * FROM `ban` WHERE content='$row->ip'";
        $count2 = mysqli_query($conn,$comd2);
        $arr3 = mysqli_fetch_assoc($count2);
        $type2 = $arr3['type'];
        if (empty($type2)) {
            $check2 = "正常";
        } else {
            $check2 = "BAN";
        }    //判断是否已经被ban
            echo "
      <tr>
        <td>$row->shorturl</td>
        <td>$row->information</td>
        <td>$row->type</td>
        <td>$row->ip</td>
        <td>$row->passwd</td>
        <td>".date("Y-m-d H:i:s",$row->time)."</td>
        <td>$check</td>
        <td>$check2</td>
        <td>
          <a href=\"./processing.php?shorturl=$row->shorturl&&type=del\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">刪除</a>";
if($check=="正常"){
  echo "<a href=\"./processing.php?shorturl=$row->shorturl&&type=domain\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">封鎖</a>";
}else{
  echo "<a href=\"./processing.php?content=$row->shorturl&&type=cancel&&from=control\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">解除封鎖</a>";
}
if($check2=="正常"){
  echo "<a href=\"./processing.php?ip=$row->ip&&type=ip\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">封鎖IP</a>";
}else{
  echo "<a href=\"./processing.php?content=$row->ip&&type=cancel&&from=control\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">解除封鎖IP</a>";
}              
     echo"</td></tr>";
    }
    echo "</table></div>";
    
    $page_next = $p+1;
    $page_last = $p-1;
    //计算一下上一页或者下一页的page
    echo "<br />";
    if($p != 1){
      echo  "<a href=\"./control.php?p=$page_last\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">上一頁</a>";
    }
    echo "&emsp;"; 
    if($p != $page_all){
      echo "<a href=\"./control.php?p=$page_next\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">下一頁</a>"; 
    }
    //按钮跳转
    echo "<br />";
    ?>
</body>
<?php require_once("../footer.php");
?>
