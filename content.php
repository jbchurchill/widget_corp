<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
?>
<?php if (isset($_GET['subj'])) {
    $sel_subj = $_GET['subj'];
    $sel_page = "";
  } elseif (isset($_GET['page'])) {
    $sel_page = $_GET['page'];
    $sel_subj = "";
  } else {
    $sel_page = "";
    $sel_subj = "";
  }
?>
<?php include("includes/header.php"); ?>
<table id="structure">
  <tr>
    <td id="navigation">
      <ul class="subjects">
        <?php
          // 3. Perform Database Query
          $subject_set = get_all_subjects();
          // 4. Use returned data
          while ($subject = mysql_fetch_array($subject_set)) {
            $encSubjId = urlencode($subject["id"]);
            if ($encSubjId == $sel_subj) {
              echo "<li class=\"selected\"><a href=\"content.php?subj=" . $encSubjId . 
                    "\">{$subject["menu_name"]}</li>"; 
            } else {
              echo "<li><a href=\"content.php?subj=" . $encSubjId . 
                    "\">{$subject["menu_name"]}</li>"; 
            }        
            $page_set = get_all_pages_for_subject($subject["id"]);
            // 4. Use returned data
            echo "<ul class=\"pages\">";
            while ($page = mysql_fetch_array($page_set)) {
              $encPageId = urlencode($page["id"]);
              if ($encPageId == $sel_page) {
                echo "<li class=\"selected\"><a href=\"content.php?page=" . urlencode($page["id"]) . 
                    "\">{$page["menu_name"]}</a></li>";
              } else {
                echo "<li><a href=\"content.php?page=" . urlencode($page["id"]) . 
                    "\">{$page["menu_name"]}</a></li>";
              }      
            }
            echo "</ul>";
          }
        ?>
      </ul>  
    </td>
    <td id="page">
	  <h2>Content Area</h2>
	  <?php echo $sel_subj; ?><br />
	  <?php echo $sel_page; ?><br />
	  
    </td>
  </tr>
</table>    
<?php
  require("includes/footer.php");
?>