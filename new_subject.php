<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/session.php"); ?>
<?php confirm_logged_in(); ?>
<?php include_once("includes/form_functions.php"); ?>
<?php
  // Start Form Processing
  if (isset($_POST['submit'])) 
?>
<?php include("includes/header.php"); ?>
<table id="structure">
  <tr>
    <td id="navigation">
    <?php echo navigation("content.php") ?>
    </td>
    <td id="page">
      <h2>Add Subject</h2>
      <form action="create_subject.php" method="post">
        <p>Subject Name: <input type="text" name="menu_name", value="" id="menu_name" /></p>
        <p>Position: 
          <select name="position">
            <?php 
              $subject_set = get_all_subjects();
              $subject_count = mysql_num_rows($subject_set);
              for ($count=1; $count <= $subject_count+1; $count++) {
                echo "<option value=\"{$count}\">{$count}</option>";
                // wouldn't it be easier to just automatically assign position to $count+1 ????
              }
            ?>
            
          </select>
        </p>
        <p>Visible: 
          <input type="radio" name="visible" value="0" />No
          &nbsp;
          <input type="radio" name="visible" value="1" />Yes
        </p>
        <input type="submit" value="Add Subject" />
      </form>
      <br />
      <a href="content.php">Cancel</a>
    </td>
  </tr>
</table>    
<?php
  require("includes/footer.php");
?>