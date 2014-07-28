<?php
  session_start();
  function logged_in () {
    return isset($_SESSION['user_id']);
  }
  function confirm_logged_in() {
    if (!logged_in()) {
    // if (!isset($_SESSION['user_id'])) {
      redirect_to("login.php");
    }
  } 
?>