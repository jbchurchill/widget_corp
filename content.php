<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
?>
<?php
  find_selected_page();
?>
<?php include("includes/header.php"); ?>
<table id="structure">
  <tr>
    <td id="navigation">
      <?php echo navigation(); ?>
      <br />
      <a href="new_subject.php">+ Add a new subject</a>
    </td>
    <td id="page">
    <?php
      // Kevin used isnull function instead of == NULL;
      if (!$select_subject == NULL) {
  	    echo "<h2>" . $select_subject['menu_name'] . "</h2>"; // concatenate
  	  } elseif (!$select_page == NULL) {
	      echo "<h2>{$select_page['menu_name']}</h2>"; // or use inline substitution 
	    } else {
	  	  echo "<h2>Select a subject or page to edit</h2>";
	    }
	  ?>
	  <div id="page-content">
	    <?php echo "{$select_page['content']}"; ?>
	  </div>
	  <div id="edit_page">
	  <br /><br />
	    <?php
	      if (!$select_page == NULL) {
	        echo "<a href=\"edit_page.php?page={$select_page['id']}\">Edit this page</a>";
	      }
	    ?>
	  </div>
	  
    </td>
  </tr>
</table>    
<?php
  require("includes/footer.php");
?>