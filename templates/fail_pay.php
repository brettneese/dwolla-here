<?php include 'head.php';?>
  <body>
       <div data-role="page" data-theme="a">
            <div data-role="header" data-position="inline">
                <h1> Sadface. </h1>
                <a href="./list" data-icon="back">Back to list</a>
            </div>
            <div data-role="content" data-theme="a">
            <div id="sent">
                <h1> Oh no! </h2>
            <h2> <?php echo $echo; ?></h2>
          <a href="#" data-role="button" data-rel="back"> Try again. </a>
          </div>    
          </div>
    </body>
</html>​