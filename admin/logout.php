<html>
    <head>
    <?php require_once('../config.php'); ?>
        <?php require_once("./header.php");?>
    </head>
    <body>
        <?php
          session_destroy();
          echo("<center><h2><br/>登出成功!轉跳中!</h2></center>");
          header("Refresh:1;url=\"../index.php\"");
        ?>
    </body>
  <?php require_once("../footer.php"); ?>
</html>
