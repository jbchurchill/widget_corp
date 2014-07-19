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
      <?php echo navigation("index.php"); ?>
      <br />
      <a href="new_subject.php">+ Add a new subject</a>
    </td>
    <td id="page">
      <div id="page-content">
      WHATS UP ?
      </div>
    </td>
  </tr>
</table>
<?php include("includes/footer.php"); ?>