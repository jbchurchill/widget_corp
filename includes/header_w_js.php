<html>
  <head>
    <title>Widget Corp</title>
    <link href="stylesheets/public.css" media="all" rel="stylesheet" type="text/css" />
    <script src="http://localhost/~jchurchi/widget_corp/javascripts/jquery.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
    
    <!-- ../javascripts/jquery.min.js = http://localhost/~jchurchi/widget_corp/javascripts/jquery.min.js -->
    <script type="text/javascript">
      function updatePosition(name, jArray) {
        // name is the id of the position select control
        
      var idx = 0; // index is subject_id minus 1
      alert(name);

      // var jArray = new Array(new Array('About Widget Corp', 1, 1, 2), new Array('Products', 2, 1), new Array('Services', 3, 1));

      var select = document.getElementById(name); // ('position');
        for(var i = 0; i < jArray[idx].length-2; i++) {
            z = i + 2
            // alert(jArray[idx][z]);
            var opt = jArray[idx][z];
            var el = document.createElement("option");
            el.textContent = opt;
            el.value = opt;
            select.appendChild(el);
        }        
      }
    </script>
  </head>
  <body>
    <div id="header">
      <h1>Widget Corp</h1>
    </div>
    <div id="main">