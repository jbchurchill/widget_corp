<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/session.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("includes/form_functions.php"); ?>
<?php
  $subject = mysql_prep($_POST['subject']);
  $menu_name = mysql_prep($_POST['menu_name']);
  $position = mysql_prep($_POST['position']);
  $visible = mysql_prep($_POST['visible']);
  $content = mysql_prep($_POST['content']);
  $subject_set = get_all_subjects();
  while ($row = mysql_fetch_array($subject_set)) {
    if ($row['menu_name'] == $subject) {
      $subject_id = $row['id'];
    }
  }
?>
<?php
  $query = "INSERT INTO pages (
    subject_id, menu_name, position, visible, content
  ) VALUES (
    {$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}'
  )";
  if (mysql_query($query, $connection));
  if (!$result_set) {
    redirect_to("content.php");
  } else {
    // Display error message  
    echo "<p>Page Creation failed.</p>";
    echo "<p>" . mysql_error() . "</p>";
  }
?>
<?php mysql_close($connection); ?>