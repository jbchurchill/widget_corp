<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
  include_once("includes/form_functions.php");
?>
<?php include("includes/header.php"); ?>
<table id="structure">
  <tr>
    <td id="navigation">
      <!-- <?php echo navigation("index.php"); ?> -->
      <br />
      <!-- <a href="new_subject.php">+ Add a new subject</a> -->
      <a href="index.php">Return to Main Page</a>
    </td>
    <td id="page">
      <h2>Login Page</h2>
      <?php
        if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";}
      ?>
      <?php
        if (!empty($errors)) {display_errors($errors); }
      ?>
      
      <div id="page-content">
        <form id="login">
          Username: <input type="text" name="user" /><br />
          Password:&nbsp; <input type="password" name="pwd" /><br />
          <input type="submit" name="login" value="Login" />
        </form>      
      </div>
    </td>
  </tr>
</table>

<?php include("includes/footer.php"); ?>