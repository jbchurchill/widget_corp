<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
?>
<?php
  find_selected_page();
?>
<?php
  if (intval($_GET['subj']) > 0) {
    $subject_id = mysql_prep($_GET['subj']);
    $subject = get_subject_by_id($subject_id);
    $page_id = false;
  } elseif (intval($_GET['page']) > 0) {
    $page_id = mysql_prep($_GET['page']);
    $page = get_page_by_id($page_id);
    $subject_id = false;
  } elseif ((intval($_GET['subj']) == 0) && (intval($_GET['page']) == 0)) {
    $subject_id = false;
    $page_id = false;
    // redirect_to("content.php");
    // NOT SURE I WANT TO DO THIS REDIRECT SINCE WE ARE IN THE PUBLIC AREA
  } else {
    // hmmm not sure what is left after that
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
      <div id="page-content">
        <?php
          if ($subject_id) {
            echo "<h2>Subject: " . htmlentities($subject['menu_name']) . " - (ID: " . htmlentities($subject_id) . ")</h2>";
            echo "Position: " . htmlentities($subject['position']) . "<br />";
            echo "Visible: " . htmlentities($subject['visible']) . "<br /><br />";
            echo "Pages: <br /><br /><ul>";
            $page_set = get_all_pages_for_subject($subject_id);
            if ($page_set) {
              while ($pagelisted = mysql_fetch_array($page_set)) {
                echo "<li><a href=\"index.php?page=" . urlencode($pagelisted['id']) . "\">" . htmlentities($pagelisted['menu_name']) . "</a></li>"; 
              }
            }
            echo "</ul>";
          }
          if ($page_id) {
            echo "<h2>Page: " . htmlentities($page['menu_name']) . " - (ID: " . htmlentities($page_id) . ")</h2>";
            echo "Position: " . htmlentities($page['position']) . "<br />";
            echo "Visible: " . htmlentities($page['visible']) . "<br /><br />";
            echo "Content: <br /><br /><p>" . strip_tags(nl2br($page['content']), "<a><p><br /><strong>") . "</p>";
          }
        ?>
      </div>
    </td>
  </tr>
</table>
<?php include("includes/footer.php"); ?>