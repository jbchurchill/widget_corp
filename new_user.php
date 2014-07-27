<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
  include_once("includes/form_functions.php");
?>
<?php
  // NOT SURE IF THIS IS NEEDED IN HERE OR NOT
  find_selected_page();
?>
<?php
    if (isset($_POST['submit'])) { // form has been submitted
      $errors = array();
      
      // perform validations on the form data
      $required_fields = array('username', 'password');
      $errors = array_merge($errors, check_required_fields($required_fields, $_POST));
      $fields_with_lengths = array('username' => 30, 'password' => 30);
      $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
      $username = trim(mysql_prep($_POST['username']));
      $password = trim(mysql_prep($_POST['password']));
      $hashed_password = sha1($password);
      
      if (empty($errors)) {
        $query = "INSERT INTO users (
          username, hashed_password
        ) VALUES (
          '{$username}', '{$hashed_password}'
        )";
        $result = mysql_query($query, $connection);
        if ($result) {
          $message = "The user was successfully created";
        } else {
          $message = "The user could not be created";
          $message .= "<br />" . mysql_error();
        }
      } else {
        if (count($errors) == 1) {
          $message = "There was 1 error in the form";
        } else {
          $message = "There were " . count($errors) . " errors in the form";
        }
      }
    } else {
      // initialize username and password so we can use them below
      $username = "";
      $password = "";
    }
?>
<?php include("includes/header.php"); ?>
<table id="structure">
  <tr>
    <td id="navigation">
      <?php echo navigation("index.php"); ?>
      <br />
      <a href="new_subject.php">+ Add a new subject</a>
    </td>
    <td id="page">
      <h2>Create New User</h2>
      <div id="page-content">
        <form id="new_user" action="new_user.php" method="post">
          Username: <input type="text" name="username" maxlength="30" value="<?php htmlentities($username); ?>" /><br />
          Password:&nbsp; <input type="password" name="password" maxlength="30" value="<?php htmlentities($password); ?>" /><br />
          <input type="submit" name="submit" value="Create User" />
        </form>
        <p>
          <?php
            if (!empty($message)) {
              echo htmlentities($message);
            }
          ?>
        </p>
      </div>
    </td>
  </tr>
</table>

<?php include("includes/footer.php"); ?>