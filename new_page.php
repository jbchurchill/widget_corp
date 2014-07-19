<?php
  require_once("includes/connection.php");
  require_once("includes/functions.php");
  require_once("includes/form_functions.php");
?>
<?php
  // find_selected_page();
  $page_passed_in = mysql_prep($_GET['subj']);
  find_selected_page();
  $subject_passed_in = $select_subject['menu_name'];
?>
<?php include("includes/header_w_js.php"); ?>

<table id="structure">
  <tr>
    <td id="navigation">
    <?php echo navigation("content.php") ?>
    </td>
    <td id="page">
      <h2>Add Page</h2>
      <form action="create_page.php" method="post">
        <p>Page Name: <input type="text" name="menu_name" id="menu_name" /></p>
          <?php 
            $position_array_for_select_control = get_positions_by_subject();
            if (count($position_array_for_select_control) > 0) {
              $test = true;
            }
            
            // print_r(json_encode($position_array_for_select_control));
            // print_r($position_array_for_select_control);
            // echo getcwd();
            // echo $page_passed_in . "<br />";
            // print_r($position_array_for_select_control);
            // echo "<br />";
            // echo max($position_array_for_select_control[$select_subject['menu_name']]) . "<br />";
            // I CAN USE THE ABOVE LINE TO SET THE DEFAULT MAX POSITION FOR THE PAGE AT THE START
            // BUT IT WON'T UPDATE WITH NEWLY SELECTED SUBJECTS
            // WHAT WOULD REALLY BE GOOD IS AN ARRAY OF THE MAX POSITION FOR EACH SUBJECT.
            $json_array = json_encode($position_array_for_select_control);
            $uSWfile = "files/uSWfile.json";
            file_put_contents($uSWfile, $json_array);
            // print_r($json_array);
            echo '<script type="text/javascript">';
            // echo "alert('hello')";
            // echo 'var js_array = json_encode($position_array_for_select_control)';
            // echo 'alert(js_array[1])';
            echo '</script>';            
          ?>

          <!-- Moved Up -->
          <?php echo "Selected Subject: " . $page_passed_in . " - " . $select_subject['menu_name'] . "<br />"; ?>  
          <p>
            Subject:<br />
            <select id="subjects" name="subject"></select><br />
          </p>
          <p>
            Position:<br />
            <select id="position" name="position"></select><br />
          </p>
        
          <!-- NEW JAVASCRIPT -->
          <script>
            
            $(document).ready(function () {
            "use strict";

              var selectData, $subjects;
              function updateSelects() {
                var positions = $.map(selectData[this.value], function (pos) {
                    return $("<option />").text(pos);
                });
                                                                                
                $("#position").empty().append(positions);
                // Set selected Position (currently works only if the selected subject is selected)
                // Selected subject being the subject the add new page was launched from.
                // THIS NEXT LINE CAUSES AN ERROR WHEN CREATING THE FIRST PAGE OF A NEW TOPIC
                // BECAUSE MAX DOES NOT WORK IF THE ARRAY IS EMPTY.
                if ("<?php echo $test; ?>" == true) {
                  $('#position').val("<?php echo max($position_array_for_select_control[$select_subject['menu_name']]); ?>");
                }

              }
              
              // $.getJSON("javascripts/updateSelectWidget.json", function (data) {
              $.getJSON("files/uSWfile.json", function (data) {
                var subject;
                selectData = data;
                $subjects = $("#subjects").on("change", updateSelects);
                for (subject in selectData) {
                  $("<option />").text(subject).appendTo($subjects);
                  if (subject == "<?php echo $subject_passed_in; ?>") {
                    $('#subjects').val("<?php echo $subject_passed_in; ?>");  // THIS IS SUPPOSED TO WORK BY value
                  }
                }
                $subjects.change();
                // testing APPARRENTLY I DO HAVE A SELECTED VALUE BUT IT DOES NOT POST
                // var val = $("#subjects option:selected").text();
                // alert(val);
                // testing END - THIS SHOWS HOW TO SEE THE SELECTED text .text() or value .val() 
              }); // MIGHT NOT NEED A FUNCTION
            });
            
          </script>
          
            

        <!--  COMMENTING OUT THE ENTIRE SUBJECT AND POSITION SECTION AND
        ADDING IT IN ABOVE.
        HAD TO FOREGO THE CREATION OF THE SELECT CONTROL 
        VIA PHP FUNCTION        
        <?php echo "Selected Subject: " . $page_passed_in . "<br />"; ?>
        <p>Subject: 
          <?php 
            echo "<script type=\"text/javascript\">";
            echo "var jArray= " . json_encode($position_array_for_select_control);
            // for(var i=0;i<jArray.length;i++){
            //   alert(jArray[i]);
            // }

            echo "</script>";
            generate_subject_select_control('subject_id', $page_passed_in, json_encode(json_encode($position_array_for_select_control)));  // Function generates select control 
          ?>
        </p>
        <p>Position: 
          <select name="position" id="position">
            <?php 
              $subject_set = get_all_subjects();
              $subject_count = mysql_num_rows($subject_set);
              for ($count=1; $count <= $subject_count+1; $count++) {
                echo "<option value=\"{$count}\">{$count}</option>";
                // wouldn't it be easier to just automatically assign position to $count+1 ????
              }
            ?>
            
          </select>
        </p>
        --> 
        <?php 
          // $subject_set = get_all_subjects();
          // while ($row = mysql_fetch_array($subject_set)) {
          //   echo "snow white: " . $row['id'] . " - " . $row['menu_name'] . "<br />";
          //   if 
          // }
          // $subject_count = mysql_num_rows($subject_set);
          // for ($count=1; $count <= $subject_count+1; $count++) {
          //   if $subject_set[
          // }          
          // echo "rumplestiltskin: " . $subject_set;
        ?>  
        
        <!-- <input type="hidden" id="subject_id" value="<?php echo some_variable; ?>" /> -->
        <p>Visible: 
          <input type="radio" name="visible" value="0" />No
          &nbsp;
          <input type="radio" name="visible" value="1" />Yes
        </p>
        <p>
          Content: <br />
          <textarea rows="4" cols="50" name="content" id="content"></textarea>
        </p>
        <input type="submit" value="Add Page" name="submit" />
      </form>
      <br />
      <a href="content.php">Cancel</a>
    </td>
  </tr>
</table>    
<?php
  require("includes/footer.php");
?>