<?php require 'templates/head.php';?>
    <div data-role="page" data-theme="a">
    <a href="./settings" data-rel="dialog" data-transition="slidedown">
      <div data-role="header" data-position="fixed"> 
      <h1>Deposit</h1>  </div>
    </a>
    <div data-role="content" data-theme="a">
            <center> <h2> <?php echo $name; ?> </h2> </center>
            <div id="send">
            <form action="deposit_action" method="post" id="dwolladwolla">
            <span>How much? </span>
            $<input type="tel" name="dollars" id="dollars" value="1" data-theme="a" /> .
            <input type="tel" name="cents" id="cents" value="00" data-theme="a" maxlength="2" /> 
          </br>
          </br>

          <span>From where? </span>
          <select name="select-choice-0" id="account">
             <?php foreach ($fundingSources as $fundingSource) {
             echo "<option value=" . $fundingSource['Id'] . ">" . $fundingSource['Name'] . "</option>";
            }?>
          </select>
        </br>
        
        <span>What's your PIN?</span>
        <input type="password"  pattern="\d*" name="pin" id="pin" value="" data-theme="a" maxlength="4" /> 

        <a href="#" id="verify"  data-role="button" rel="external"> Deposit! </a>
        <h3> Your current Dwolla balance is $<?php echo $balance?>. </h3>
        </form>
      
        <a href="#" data-rel="back"  data-role="button">Back</a> </center>
           <script>                
            $("#verify").click(function() {
              var dollars = $("#dollars").val();
              var cents = $("#cents").val();
              var pin = $("#pin").val();
            var account = $("#account option:selected").text();

              if (pin == "" || pin.length < '4') {
                alert("Please enter a valid PIN.");
              } else {
                if (cents == "") {
                  if (confirm("Deposit $" + dollars + "." + cents + " from " + account + "? Note: if this is an ACH transfer, it will take 3-7 business days to process.")) {
                    $('#dwolladwolla').submit();
                  }
                } else {
                  if (confirm("Deposit $" + dollars + " from " + account + "? Note: if this is an ACH transfer, it will take 3-7 business days to process.")) {
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
                $("#hideme").hide();
              } else {
                $("#cents").val("00");
                $("#cents").fadeIn("1");
                $("#hideme").fadeIn("1");
              }
            }); 
            
           </script>
        </div>
</body>
</html>​