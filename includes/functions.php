<?php 
  // This file is a place to store all our functions
  function mysql_prep ($value) {
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists("mysql_real_escape_string" ); // i.e. PHP >= 4.3.0
    if ( $new_enough_php ) { // PHP 4.3.0 or higher
      // undo any magic quote effects so mysql_real_escape_string can do the work
      if ( $magic_quotes_active ) { $value = stripslashes( $value ); }
      $value = mysql_real_escape_string( $value );
    } else { // before PHP v4.3.0
      // if magic quotes aren't already on then add slashes manually
      if ( !magic_quotes_active ) { $value = addslashes( $value ); }
      // if magic quotes are active, then the slashes already exist
    }
    return $value;
  }
  function redirect_to ($location = NULL) {
    if ($location != NULL) {
      header("Location: {$location}");
      exit;
    }
  }
  function confirm_query ($result_set) {
    if (!$result_set) {
      die("Database query failed: " . mysql_error());
    }
  }
  function get_all_subjects ($public = true) {
    global $connection;
    $query = "SELECT * 
          FROM subjects ";
    if ($public) {
      $query .= "WHERE visible = 1 ";
    } 
    $query .= "ORDER BY position ASC ";
    $subject_set = mysql_query($query, $connection);
    confirm_query($subject_set);
    return $subject_set;
  }
  function get_all_pages_for_subject($subject_id) {
    global $connection;
    $query = "SELECT * 
          FROM pages 
          WHERE subject_id = {$subject_id}";
    $page_set = mysql_query($query, $connection);
    confirm_query($page_set);
    return $page_set;
  }
  function get_subject_by_id ($subject_id) {
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM subjects ";
    $query .= "WHERE id=" . $subject_id . " ";
    $query .= "LIMIT 1";
    $result_set = mysql_query($query, $connection);
    confirm_query($result_set);
    // REMEMBER
    // if no rows are returned, fetch_array will return false
    if ($subject = mysql_fetch_array($result_set)) {
      return $subject;
    } else {
      return NULL;
    }
  }
  function get_page_by_id ($page_id) {
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM pages ";
    $query .= "WHERE id=" . $page_id . " ";
    $query .= "LIMIT 1";
    $result_set = mysql_query($query, $connection);
    confirm_query($result_set);
    if ($page = mysql_fetch_array($result_set)) {
      return $page;
    } else {
      return NULL;
    }
  }
  function find_selected_page() {
    global $select_subject;
    global $select_page;
    if (isset($_GET['subj'])) {
      $sel_subj = $_GET['subj'];
      $select_page = NULL;
      $select_subject = get_subject_by_id($sel_subj);
    } elseif (isset($_GET['page'])) {
      $select_subject = NULL;
      $sel_page = $_GET['page'];
      $select_page = get_page_by_id($sel_page);
    } else {
      $select_page = NULL;
      $select_subject = NULL;
    }
  }
  function navigation($start_page) {
    global $select_subject;
    global $select_page;
    $output = "<ul class=\"subjects\">";
      // 3. Perform Database Query
      if ($start_page == "content.php") {
        $public = false;
      } else {
        $public = true;
      }
      $subject_set = get_all_subjects($public);
      // 4. Use returned data
      while ($subject = mysql_fetch_array($subject_set)) {
        $encSubjId = urlencode($subject["id"]);
        if ($encSubjId == $select_subject['id']) { // this runs only for the selected subject
          if ($start_page == "content.php") {
            $output .= "<li class=\"selected\"><a href=\"edit_subject.php?subj=" . $encSubjId . 
                  "\">{$subject["menu_name"]}</li>"; 
          } elseif ($start_page == "index.php") {
            $output .= "<li class=\"selected\"><a href=\"index.php?subj=" . $encSubjId .
                  "\">{$subject["menu_name"]}</li>"; 
          } else {
            echo "WHAT IS YOUR START PAGE ?";
          }
        } else { // this runs for subject headings other than the one selected
          if ($start_page == "content.php") {
            $output .= "<li><a href=\"edit_subject.php?subj=" . $encSubjId . 
                  "\">{$subject["menu_name"]}</li>"; 
          } elseif ($start_page == "index.php") {
            $output .= "<li><a href=\"index.php?subj=" . $encSubjId . 
                  "\">{$subject["menu_name"]}</li>";           
          } else {
            echo "WHAT IS YOUR START PAGE ?";
          }        
        }
        $output .= "<ul class=\"pages\">";
        $page_set = get_all_pages_for_subject($subject["id"]);
        // MAKE ALL OF THIS WORK ONLY ON THE SELECTED SUBJECT
        if (($subject['id'] == $select_subject['id']) || ($subject['id'] == $select_page['subject_id'])) {

          // 4. Use returned data

          while ($page = mysql_fetch_array($page_set)) {
            $encPageId = urlencode($page["id"]);
            if ($encPageId == $select_page['id']) {
              if ($start_page == "content.php") {
                $output .= "<li class=\"selected\"><a href=\"content.php?page=" . urlencode($page["id"]) . 
                      "\">{$page["menu_name"]}</a></li>";            
              } elseif ($start_page == "index.php") {
                $output .= "<li class=\"selected\"><a href=\"index.php?page=" . urlencode($page["id"]) . 
                      "\">{$page["menu_name"]}</a></li>";
              } else {
                // hmmmm
              }
            } else {
              if ($start_page == "content.php") {
                $output .= "<li><a href=\"content.php?page=" . urlencode($page["id"]) . 
                      "\">{$page["menu_name"]}</a></li>";
              } elseif ($start_page == "index.php") {
                $output .= "<li><a href=\"index.php?page=" . urlencode($page["id"]) . 
                     "\">{$page["menu_name"]}</a></li>";
              } else {
                echo "WHAT IS YOUR START PAGE ?";
              }
            } // end of else related to whether a page was selected or not.
          } // end of while
          } // end of if
          $output .= "</ul>";
      }
    $output .= "</ul>";
    return $output;
  }
?>