<?php
  require("constants.php");
  $connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
  if (!$connection) {
    die("Database Connection Failed: " . mysql_error());
  }
  $db_select = mysql_select_db(DB_NAME, $connection);
  if (!$db_select) { 
    die("Database Selection Failed: " . mysql_error());
  }
?>