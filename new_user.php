<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
?>
<?php
  // NOT SURE IF THIS IS NEEDED IN HERE OR NOT
  find_selected_page();
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
      <div id="page-content">
        <form id="new_user">
          Username: <input type="text" name="user" /><br />
          Password:&nbsp; <input type="password" name="pwd" /><br />
          <input type="submit" name="submit" value="Create User" />
        </form>
      </div>
    </td>
  </tr>
</table>

<?php include("includes/footer.php"); ?>