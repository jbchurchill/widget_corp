<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
?>
<?php 
  if (intval($_GET['page']) == 0) {
    redirect_to("content.php");
  }
?>
<?php include_once("includes/form_functions.php"); ?>
<?php
  if (isset($_POST['submit'])) {
    // DO UPDATE OPERATIONS BECAUSE DATA HAS BEEN POSTED FROM THIS FORM.
    $errors = array();
    
    $required_fields = array('subject_id', 'menu_name', 'position', 'visible', 'content');
    $errors = array_merge($errors, check_required_fields($required_fields));

    $fields_with_lengths = array('menu_name' => 30);
    $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
    
    if (empty($errors)) {
      // There are no Errors - Perform Update
      $id = mysql_prep($_GET['page']);
      $subject_id = mysql_prep($_POST['subject_id']);
      $menu_name = trim(mysql_prep($_POST['menu_name']));
      $position = mysql_prep($_POST['position']);
      $visible = mysql_prep($_POST['visible']);
      $content = mysql_prep($_POST['content']);
      
      $query = "UPDATE pages SET 
                  subject_id = {$subject_id},
                  menu_name = '{$menu_name}', 
                  position = {$position}, 
                  visible = {$visible},
                  content = '{$content}'
                  WHERE id = {$id}";           
      $result = mysql_query($query, $connection);
      // mysql_affected_rows() takes no argument but runs on the most recently run query
      if (mysql_affected_rows() == 1) {
        // if there is one affected row, the query ws successful
        $message = "The page was successfully updated";
      } else {
        // Query Failed
        $message = "The page update failed";
        $message .= "<br /> " . mysql_error();
      }
    // Else - There are errors  
    } else {
      $validation_errcount = count($errors);
      if ($validation_errcount == 1) {
        $message = "There was " . $validation_errcount . " error in the form";
      } else {
        $message = "There were " . count($errors) . " errors in the form";
      } // End of inner else
      // Errors occurred
    } // End of outer else
  } // End of isset() section
?>
<?php
  find_selected_page();
?>
<?php include("includes/header.php"); ?>
<!-- <?php echo $select_page['position']; ?> -->
<table id="structure">
  <tr>
    <td id="navigation">
      <?php echo navigation("content.php"); ?>
      <br />
      <a href="new_page.php">+ Add a new page</a>
    </td>
    <td id="page">
      <?php
        // Should only ever be the second choice since that is the only link that is provided
        // if (!$select_subject == NULL) {
        //   echo "<h2>{$select_subject['menu_name']}</h2>"; // inline substitution 
        // } elseif (!$select_page == NULL) {
        //   echo "<h2>Edit " . $select_page['menu_name'] . "</h2>"; // or concatenate
        // } else {
        //   echo "<h2>Select a subject or page to edit</h2>";
        // }
      ?>
      <?php 
        if (!empty($message)) {
          echo "<p class=\"message\">{$message}";
        }
      ?>
      <?php
        // Output a list of errors
        if (!empty($errors)) {
          echo "<p class=\"errors\">";
          echo "Please review the following fields: <br />";
          foreach($errors as $error) {
            echo " - " . $error . "<br />";
          }
          echo "</p>";
        }        
      ?>
      
      <form id="edit_page" action="edit_page.php?page=<?php echo urlencode($select_page['id']); ?>" method="post">
        <p>Page Name: <input type="text" name="menu_name", value="<?php echo $select_page['menu_name']; ?>" id="menu_name" /></p>
        <p>Subject:
          <select name="subject_id">
          <?php 
            $subject_set = get_all_subjects();
            $subject_count = mysql_num_rows($subject_set);
            for ($count=1; $count <= $subject_count; $count++) {
              if ($count == $select_page['subject_id']) {
                echo "<option value=\"{$count}\" selected>{$count}</option>"; 
              } else {
                // a subject that is not related to this page
                echo "<option value=\"{$count}\">{$count}</option>";
              }
            }
            // echo "";
          ?>
          </select>
        </p>
        <p>Position:
          <select name="position">
            <?php 
              // $subject_set = get_all_subjects(); // ALREADY DONE
              // $subject_count = mysql_num_rows($subject_set);
              for ($count=1; $count <= $subject_count+1; $count++) {
                if ($select_page['position'] == $count) {
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
            switch ($select_page['visible']) {
              case 0:
                echo "<input type=\"radio\" name=\"visible\" value=\"0\" checked />No";
                echo " ";
                echo "<input type=\"radio\" name=\"visible\" value=\"1\" />Yes";
                break;
              case 1:
                echo "<input type=\"radio\" name=\"visible\" value=\"0\" />No";
                echo " ";
                echo "<input type=\"radio\" name=\"visible\" value=\"1\" checked />Yes";
                break;
            }    
          ?>    
        </p>
        <p>Content:<br />
          <textarea name="content" value="" rows="4" cols="50"><?php echo $select_page['content']; ?></textarea>
        </p>
        <input type="submit" name="submit" value="Edit Page" />
        &nbsp;&nbsp;
        <a href="delete_page.php?page=<?php echo urlencode($select_page['id']); ?>" onclick="return confirm('Are you sure?');">Delete Page</a>        
      </form>
      <br />
      <a href="content.php">Cancel</a>
    </td>
  </tr>
</table>    
    
<?php
  include("includes/footer.php");
?>