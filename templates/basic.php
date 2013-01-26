<?php require 'templates/head.php';?>


    <body>
      <div data-role="page" data-theme="a">
      
      <div data-role="header" data-position="inline">
              <a href="#" data-rel="back" data-icon="back" data-iconpos="notext">Back</a>
                <h1> <?php echo $id; ?> </h1>
            </div>
            <div data-role="content" data-theme="a">

                <center> <h2> <?php echo $name; ?> </h2> </center>

                <div id="send">
                <form action="../pay" method="post" id="dwolladwolla">

                <span>How much?</span>
                $<input pattern="\d*" name="dollars" id="dollars" value="" data-theme="a" />
              <span id="hideme"> . <input pattern="\d*" name="cents" id="cents" value="" data-theme="a" maxlength="2" /> </span>
                
                </br>

                <span>What's your PIN?</span>
                <input type="password"  pattern="\d*" name="pin" id="pin" value="" data-theme="a" maxlength="4" /> 

                <a href="#" id="verify"  data-role="button" rel="external"> Pay with Dwolla! </a>
                <h3> Your current Dwolla balance is $<?php echo $balance?>. </h3>
                </form>
                

               <script>                
                $("#verify").click(function() {
                  var dollars = $("#dollars").val();
                  var cents = $("#cents").val();
                  var pin = $("#pin").val();
                  if (pin == "" || pin.length < '4') {
                    alert("Please enter a valid PIN.");
                  } else if(cents == "" && dollars == ""){

                    alert("Please enter a valid amount to send!");
                  } 
                    else{

                    if (cents == "") {
                        if (confirm("Pay $" + dollars + " to <?php echo $name; ?> with Dwolla ID <?php echo $id;?>?")) {
                        $('#dwolladwolla').submit();
                   
                      }
                    } else {
                        if (confirm("Send $" + dollars + "." + cents + " to <?php echo $name; ?> with Dwolla ID <?php echo $id;?>?")) {
                        $('#dwolladwolla').submit();
                      }
                    }
                  }
                });
                $(document).ready(function() {
                  $('#cents').autotab_filter('numeric');
                  $('#dollars').autotab_filter({
                    format: 'custom',
                    pattern: '[^0-9\.]'
                  });
                });

    


                $("#dollars").blur(function() {
                  var value = $(this).val();
                  if (/[.]+/.test(this.value)) {
                    $("#cents").val("");
                    $("#hideme").fadeOut();
                  } else {
                    $("#cents").fadeIn("1");
                    $("#hideme").fadeIn("1");
                  }
                }); 
                
               </script>
            </div>
      
    </body>
</html>​