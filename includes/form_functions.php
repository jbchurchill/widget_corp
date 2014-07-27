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
  function generate_subject_select_control($name, $subject_id, $jArray) {
    include_once("functions.php");
    $subject_set = get_all_subjects();
    echo "<select name=\"{$name}\" id=\"{$name}\" onchange=\"updatePosition('position', $jArray)\">";
    while ($row = mysql_fetch_array($subject_set)) {
      if ($row['id'] == $subject_id) {
        echo "<option value=\"{$row['id']}\" selected>{$row['menu_name']}</option><br />";
      } else {
        echo "<option value=\"{$row['id']}\">{$row['menu_name']}</option><br />";
      }
    }
    // THIS FUNCTION IS DEPRECATED (at least temporarily) in favor
    // of the jquery function that updates the position control based on the selected subject.
    // $subj_array = mysql_fetch_array($subject_set);
    // echo "<select>";
    // foreach ($subject_set as $subject) {
      // echo "<option value=\"{$subject_set['id']}\">{$subject_set['menu_name']}</option>";
     // echo "<option value=\"{$subject['id']}\">{$subject['menu_name']}</option>";
    //}
    echo "<select>";
  }
  function get_positions_by_subject() {
    // Returns a nested array ($subject_array) that consists of 2 parts
    // The first value is the Subject Name (menu_name), the second Value is
    // the array of position values for that subject.   
    include_once("functions.php");
    $subject_set = get_all_subjects();
    $subject_array = array();
    $n = 0;
    while ($subject = mysql_fetch_array($subject_set)) {
      $page_set = get_all_pages_for_subject($subject['id']);
      $position_array = array();
      while ($page_position = mysql_fetch_array($page_set)) {
        // echo $subject['id'] . " - " . $page_position['position'] . "<br />";
        $position_array[] = $page_position['position'];
      }
      // Add one extra value to the position array to give us
      // the best option for a new page.
      if (count($position_array) > 0) {
        $max_value = max($position_array);
      } else {
        $max_value = 0;
      }
      $extra_value = $max_value + 1;
      $position_array[] = $extra_value;
      // $subject_array[$n] = array($subject['menu_name'], $subject['id'], $position_array);
      // make an array of positions for each subject
      $subject_array[$subject['menu_name']] = $position_array;
      $n += 1;
    }
    // print_r($subject_array);
    return $subject_array;
  }
  function display_errors($errors) {
    foreach ($errors as $error) {
      echo "Check " . $error . " for errors<br />";
    }
  }
?>