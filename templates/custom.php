<?php require 'templates/head.php';?>
    <body>
      <div data-role="page" data-theme="a">
      <div data-role="header" data-position="inline">
              <a href="./list" data-icon="back" data-iconpos="notext">Back</a>
                <h1> Custom Dwolla ID </h1>
            </div>
            <div data-role="content" data-theme="a">
                <div id="send">
                <form id="dwolladwolla">
                  <center> <h2>Which Dwolla ID?</h2> </br> </center>
                  <center> <input type="tel" name="part_1" id="part_1" value="812" data-theme="a" maxlength="3" readonly/> -
                  <input type="tel" name="part_2" id="part_2" value="" data-theme="a" maxlength="3" /> -
                  <input type="tel" name="part_3" id="part_3" value="" data-theme="a" maxlength="4" /> </center>
                  <a href="#" id="verify"  data-role="button" rel="external"> Go! </a>
              </form>
               <script>                
                $("#verify").click(function() {
                  var part_1 = $("#part_1").val();
                  var part_2 = $("#part_2").val();
                  var part_3 = $("#part_3").val();

                  if (part_1 != "812" || part_2.length < '3' || part_3.length < '4') {
                    alert("Please enter a valid Dwolla ID!");
                  } else {
                    window.location.replace("http://labs.brneese.com/dwolla-here/id/" + part_1 + "-" + part_2 + "-" + part_3);
                  }
                });
                $(document).ready(function() {
                  $('#part_1, #part_2, #part_3').autotab_filter('numeric');
                  $('#part_1, #part_2, #part_3').autotab_magic();
                                });

               </script>
            </div>  
    </body>
</html>​