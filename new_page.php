<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
  require_once("includes/form_functions.php");
?>
<?php
  find_selected_page()
?>
<?php include("includes/header.php"); ?>
<table id="structure">
  <tr>
    <td id="navigation">
    <?php echo navigation() ?>
    </td>
    <td id="page">
      <h2>Add Page</h2>
      <form action="create_page.php" method="post">
        <p>Page Name: <input type="text" name="menu_name" /></p>
        <p>Subject: <?php generate_subject_select_control('subject_id'); ?>
        </p>
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
        <p>
          Content: <br />
          <textarea rows="4" cols="50" name="content" id="content"></textarea>
        </p>
        <input type="submit" value="Add Page" name="submit" />
      </form>
      <br />
      <a href="content.php">Cancel</a>
    </td>
  </tr>
</table>    
<?php
  require("includes/footer.php");
?>