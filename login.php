<?php
  require_once("includes/session.php");
  require_once("includes/connection.php");
  require_once("includes/functions.php");
  include_once("includes/form_functions.php");
?>
<?php
  if (isset($_POST['login'])) { // form has been submitted
    $errors = array();
    // perform validations on the form data
    $required_fields = array('username', 'password');
    $errors = array_merge($errors, check_required_fields($required_fields));
    $fields_with_lengths = array('username' => 30, 'password' => 30);
    $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
    $username = trim(mysql_prep($_POST['username']));
    $password = trim(mysql_prep($_POST['password']));
    $hashed_password = sha1($password);

    if (empty($errors)) { // $errors is empty
      $query = "SELECT id, username ";
      $query .= "FROM users ";
      $query .= "WHERE username = '{$username}' ";
      $query .= "AND hashed_password = '{$hashed_password}'";
      // echo $query . "<br />";
      $result = mysql_query($query, $connection);
      confirm_query($result);
      if ($result && mysql_num_rows($result) == 1) {
        $found_user = mysql_fetch_array($result);
        $_SESSION['user_id'] = $found_user['id'];
        $_SESSION['username'] = $found_user['username'];
        redirect_to("staff.php");
        // $message = "The user was successfully authenticated";
      } else {
        include("includes/header.php");
        $message = "The user or password is incorrect";
        $message .= mysql_error();
      }
    } else { // $errors is not empty
      if (count($errors) == 1) {
        $message = "There was 1 error in the form";
      } else {
        $message = "There were " . count($errors) . " errors in the form";
      }    
    }
  } else { // form was not submitted
    // initialize username and password so we can use them below
    include("includes/header.php"); 
    $username = "";
    $password = "";
  }
?>
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
        if (!empty($message)) {echo "<p class=\"message\">" . htmlentities($message) . "<br /></p>";}
      ?>
      <?php
        if (!empty($errors)) {display_errors($errors); }
      ?>
      <div id="page-content">
        <form id="login" action="login.php" method="post">
          Username: <input type="text" name="username" /><br />
          Password:&nbsp; <input type="password" name="password" /><br />
          <input type="submit" name="login" value="Login" />
        </form>
      </div>
    </td>
  </tr>
</table>

<?php include("includes/footer.php"); ?>