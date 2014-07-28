<?php require_once("includes/functions.php"); ?>
<?php
  // 1) Find the session (using "start_session()").
  start_session();

  // 2) Unset all the session variables. $_SESSION = array();
  $_SESSION = array();

  // 3) Destroy the session cookie e.g. if (isset($_COOKIE[session_name])) { set cookie(session_name(), '', time()-42000, '/'); }
  if (isset($_COOKIE[session_name])) {
    set cookie(session_name(), '', time()-42000, '/'); 
  }
  
  // 4) Destroy the session.
  session_destroy();
?>