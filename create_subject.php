<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
?>
<?php
  // Form Validation
  $requiredfields =  array('menu_name', 'position', 'visible');
  foreach ($requiredfields as $fieldname) {
    if (!isset($_POST['$fieldname']) || empty($_POST['$fieldname'])) {
      $errors[] = 'menu_name';
    }
  }
  if (!empty($errors)) {
    redirect_to("new_subject.php");
  }
?>
<?php
  $menu_name = mysql_prep($_POST['menu_name']);
  $position = mysql_prep($_POST['position']);
  $visible = mysql_prep($_POST['visible']);
?>
<?php
  $query = "INSERT INTO subjects (
    menu_name, position, visible
  ) VALUES (
    '{$menu_name}', {$position}, {$visible}
  )";
  if (mysql_query($query, $connection));
  if (!$result_set) {
    // Success
    header("Location: content.php");
  } else {
    // Display error message  
    echo "<p>Subject Creation failed.</p>";
    echo "<p>" . mysql_error() . "</p>";
  }
?>