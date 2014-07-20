<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
?>
<?php 
  if (intval($_GET['subj']) == 0) {
    redirect_to("content.php");
  }
  if (isset($_POST['submit'])) {
    // DO UPDATE OPERATIONS BECAUSE DATA HAS BEEN POSTED FROM THIS FORM.
    $errors = array();
    
    $required_fields = array('menu_name', 'position', 'visible');
    foreach($required_fields as $fieldname) {
      if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname])) && !is_numeric($_POST[$fieldname])) {
        $errors[] = $fieldname;
      }
    }
    $fields_with_lengths = array('menu_name' => 30);
    foreach($fields_with_lengths as $fieldname => $maxlength) {
      if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
        $errors[] = $fieldname;
      }
    }
    
    if (empty($errors)) {
      // Perform Update
      $id = mysql_prep($_GET['subj']);
      $menu_name = mysql_prep($_POST['menu_name']);
      $position = mysql_prep($_POST['position']);
      $visible = mysql_prep($_POST['visible']);
      
      $query = "UPDATE subjects SET 
                  menu_name = '{$menu_name}', 
                  position = {$position}, 
                  visible = {$visible}
                  WHERE id = {$id}";
      $result = mysql_query($query, $connection);
      // mysql_affected_rows() takes no argument but runs on the most recently run query
      if (mysql_affected_rows() == 1) {
        // if there is one affected row, the query ws successful
        $message = "The subject was successfully updated";
      } else {
        // Query Failed
        $message = "The subject update failed";
        $message .= "<br /> " . mysql_error();
      }
    } else {
      $validation_errcount = count($errors);
      if ($validation_errcount == 1) {
        $message = "There was " . $validation_errcount . " error in the form";
      } else {
        $message = "There were " . count($errors) . " errors in the form";
      }  
      // Errors occurred
    }
    
  } // end of if(isset($_POST['submit'])) {} section
?>
<?php
  find_selected_page();
?>
<?php include("includes/header.php"); ?>
<table id="structure">
  <tr>
    <td id="navigation">
    <?php echo navigation("content.php") ?>
    </td>
    <td id="page">
      <h2>Edit Subject <?php echo $select_subject['menu_name']; ?></h2>
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
      <form action="edit_subject.php?subj=<?php echo urlencode($select_subject['id']); ?>" method="post">
        <p>Subject Name: <input type="text" name="menu_name", value="<?php echo $select_subject['menu_name']; ?>" id="menu_name" /></p>
        <p>Position:
          <select name="position">
            <?php 
              $public = false;
              $subject_set = get_all_subjects($public);
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
                break;
              case 1:
                echo "<input type=\"radio\" name=\"visible\" value=\"0\" />No";
                echo " ";
                echo "<input type=\"radio\" name=\"visible\" value=\"1\" checked />Yes";
                break;
            }    
          ?>    
        </p>
        <input type="submit" name="submit" value="Edit Subject" />
        &nbsp;&nbsp;
        <a href="delete_subject.php?subj=<?php echo urlencode($select_subject['id']); ?>" onclick="return confirm('Are you sure?');">Delete Subject</a>
      </form>
      <br />
      <a href="content.php">Cancel</a>      
      <br />
      <hr />

      <h2>Pages under this Subject</h2
      <p>
        <?php echo "<h3>Subject: " . $select_subject['menu_name'] . " - " . $select_subject['id'] . "</h3>"; ?>
        <?php 
          $page_set = get_all_pages_for_subject($select_subject['id'], $public); // $select_subject['id']);
          echo "Number of Pages: " . mysql_num_rows($page_set) . "<br />";
          echo "Subject Id: " . $select_subject['id'] . "<br />";
          if (!mysql_num_rows($page_set) == 0) {
          
            echo "<ul>";
            ////////$page_result = mysql_fetch_array($page_set);
            ////////print_r(array_values($page_result));
            while($page = mysql_fetch_array($page_set)) {
              echo "<li><a href=\"content.php?page={$page['id']}\">
              {$page['menu_name']}</a></li>";
            }
            echo "</ul>";
          } // End of if numrows == 0
          ?>
          <a href="new_page.php?subj=<?php echo $select_subject['id']; ?>">+ Add New Page</a>          
      </p>
      
    </td>
  </tr>
</table>    
<?php
  require("includes/footer.php");
?>