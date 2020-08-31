<html>
<head>
  <title>BAN</title>
  <?php
  require_once("./header.php");
  $comd = "SELECT * FROM `ban` order by time DESC";
  $sql = mysqli_query($conn,$comd);
  $arr=mysqli_fetch_assoc($sql);
  $content=$arr['content'];
  if (empty($content))
  {
    echo("<center><h2>暫時沒有封鎖的內容</h2></center>");
    require_once("../footer.php");
    exit();
  }else{
    echo "封鎖列表:<br /><br /><center><div class=\"mdui-table-fluid\">
                        <table class=\"mdui-table mdui-table-hoverable\">
                            <tr>
                                <th>種類</th>
                                <th>IP或短網址</th>
                                <th>狀態</th>
                            </tr>";
  }
  $comd = "SELECT * FROM `ban` order by time DESC";
  $sql = mysqli_query($conn,$comd);
  while ($row = mysqli_fetch_object($sql)) {
      echo("
      <tr>
        <td>$row->type</td>
        <td>$row->content</td>
              <td>
              <a href=\"./processing.php?content=$row->content&&type=cancel&&from=ban\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">解除封鎖</a>
              </td>

      </tr>");
  }
  echo("</table></div>");
  ?>
</body>
<?php 
require_once("../footer.php");
?>
