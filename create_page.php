<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
  require_once("includes/form_functions.php");
?>
<?php
  // Form Validation
  $errors = array();
  // $requiredfields = array('subject_id', 'menu_name', 'position', 'visible', 'content');
  $requiredfields = array('subject_id', 'menu_name', 'position', 'visible', 'content');
  $errors = array_merge($errors, check_required_fields($requiredfields));
  //foreach ($requiredfields as $fieldname) {
  //  if (!isset($_POST['$fieldname']) || empty($_POST['$fieldname'])) {
  //    $errors[] = 'menu_name';
  //  }
  // }
  
  // $fields_with_lengths = array('menu_name' => 30);
  // $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
  // foreach($fields_with_lengths as $fieldname => $maxlength) {
  //   if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
  //     $errors[] = $fieldname;
  //   }
  // }
  

  if (!empty($errors)) {
    redirect_to('new_subject.php');
  }
?>
<?php
  $subject_id = mysql_prep($_POST['subject_id']);
  $menu_name = mysql_prep($_POST['menu_name']);
  $position = mysql_prep($_POST['position']);
  $visible = mysql_prep($_POST['visible']);
  $content = mysql_prep($_POST['content']);
?>
<?php
  $query = "INSERT INTO pages (
    subject_id, menu_name, position, visible, content
  ) VALUES (
    {$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}'
  )";
  if (mysql_query($query, $connection));
  if (!$result_set) {
    header("Location: content.php");
    // echo "SUBJECT ID: " . $subject_id . "<br />MENU NAME: " . $nenu_name . "<br />POSITION: " . $position . "<br />VISIBLE: " . $visible . "<br />CONTENT: " . $content;
    exit;
  } else {
    // Display error message  
    echo "<p>Page Creation failed.</p>";
    echo "<p>" . mysql_error() . "</p>";
  }
?>
<?php mysql_close($connection); ?>