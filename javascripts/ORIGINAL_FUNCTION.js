  function get_positions_by_subject() {
    // Returns a nested array ($subject_array) that consists of 3 parts
    // The first value is the Subject Name (menu_name), the second Value is the Subject ID
    // and the third value is the array of position values for that subject.
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
      $subject_array[$n] = array($subject['menu_name'], $subject['id'], $position_array);
      $n += 1;
    }
    // print_r($subject_array);
    return $subject_array;    
  }