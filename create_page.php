<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
  require_once("includes/form_functions.php");
?>
<!--
<?php
  // Form Validation
  $errors = array();
  // $requiredfields = array('subject_id', 'menu_name', 'position', 'visible', 'content');
  $requiredfields = array('subject_id', 'menu_name', 'position', 'visible', 'content');
  $errors = array_merge($errors, check_required_fields($requiredfields));
  foreach ($requiredfields as $fieldname) {
    if (!isset($_POST['$fieldname']) || empty($_POST['$fieldname'])) {
      $errors[] = 'menu_name';
    }
  }
  
  $fields_with_lengths = array('menu_name' => 30);
  $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
  foreach($fields_with_lengths as $fieldname => $maxlength) {
    if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
      $errors[] = $fieldname;
    }
  }
  
  if (!empty($errors)) {
    foreach ($errors as $error) {
      echo "You have errors in: " . $error . "<br />";
    }
  }

  // if (!empty($errors)) {
  //   redirect_to('new_subject.php');
  // }
?>
-->
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
  print_r($_POST);
  echo "<br />";
  echo "Subject: " . $subject;
  echo "Subject_id: " . $subject_id;
  echo "Menu Name: " . $menu_name;
  echo "Position: " . $position;  
  echo "Visible: " . $visible;
  echo "Content: " . $content;
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
    // header("Location: content.php");
    // echo "SUBJECT ID: " . $subject_id . "<br />MENU NAME: " . $nenu_name . "<br />POSITION: " . $position . "<br />VISIBLE: " . $visible . "<br />CONTENT: " . $content;
    // exit;
  } else {
    // Display error message  
    echo "<p>Page Creation failed.</p>";
    echo "<p>" . mysql_error() . "</p>";
  }
?>
<?php mysql_close($connection); ?>