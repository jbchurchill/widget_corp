<?php
  function check_required_fields($required_fields = array()) {
    $errors = array();
    foreach($required_fields as $fieldname) {
      if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname])) && !is_numeric($_POST[$fieldname])) {
      // echo $fieldname;
        $errors[] = $fieldname;
      }
    }
    return $errors;
  }
  function check_max_field_lengths($fields_with_lengths) {
    $errors = array();
    foreach($fields_with_lengths as $fieldname => $maxlength) {
      if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
        $errors[] = $fieldname;
      }
    }
    return $errors;
  }
  function generate_subject_select_control($name, $subject_id) {
    include_once("functions.php");
    $subject_set = get_all_subjects();
    echo "<select name=\"{$name}\" id=\"{$name}\">";
    while ($row = mysql_fetch_array($subject_set)) {
      if ($row['id'] == $subject_id) {
        echo "<option value=\"{$row['id']}\" selected>{$row['menu_name']}</option><br />";
      } else {
        echo "<option value=\"{$row['id']}\">{$row['menu_name']}</option><br />";
      }
    }
    // $subj_array = mysql_fetch_array($subject_set);
    // echo "<select>";
    // foreach ($subject_set as $subject) {
      // echo "<option value=\"{$subject_set['id']}\">{$subject_set['menu_name']}</option>";
     // echo "<option value=\"{$subject['id']}\">{$subject['menu_name']}</option>";
    //}
    echo "<select>";
  }
?>