<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
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
      <h2>Edit Subject <?php echo $select_subject['menu_name']; ?></h2>
      <form action="edit_subject.php" method="post">
        <p>Subject Name: <input type="text" name="menu_name", value="<?php echo $select_subject['menu_name']; ?>" id="menu_name" /></p>
        <p>Position: 
          <select name="position">
            <?php 
              $subject_set = get_all_subjects();
              $subject_count = mysql_num_rows($subject_set);
              for ($count=1; $count <= $subject_count+1; $count++) {
                if ($select_subject['position'] == $count) {
                  echo "<option value=\"{$count}\" selected>{$count}</option>"; 
                } else {
                  echo "<option value=\"{$count}\">{$count}</option>";
                  // wouldn't it be easier to just automatically assign position to $count+1 ????
                }
              }
            ?>
            
          </select>
        </p>
        <p>Visible: 
          <?php 
            switch ($select_subject['visible']) {
              case 0:
                echo "<input type=\"radio\" name=\"visible\" value=\"0\" checked />No";
                echo " ";
                echo "<input type=\"radio\" name=\"visible\" value=\"1\" />Yes";
              case 1:
                echo "<input type=\"radio\" name=\"visible\" value=\"0\" />No";
                echo " ";
                echo "<input type=\"radio\" name=\"visible\" value=\"1\" checked />Yes";
            }    
          ?>    
        </p>
        <input type="submit" value="Edit Subject" />
      </form>
      <br />
      <a href="content.php">Cancel</a>
    </td>
  </tr>
</table>    
<?php
  require("includes/footer.php");
?>