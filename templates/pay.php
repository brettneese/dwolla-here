<?php include 'head.php';?>
	<body>
			<div data-role="page" data-theme="a">
            <div data-role="header" data-position="inline">
                <h1> Woot! </h1>
                <a href="./list" data-icon="back">Back to list</a>
            </div>
           
            <div data-role="content" data-theme="a">
            <div id="sent">
            <h1>  <?php echo $echo; ?> </h1>
            <h2> <?php echo $DestinationName; ?> </h2>
            <h2>  <?php echo $id; ?> </h1>
            <h2> $<?php echo $amount; ?> </h2>

            <div style="margin: auto; width: 175px;">
                     <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://labs.brneese.com/dwolla-here/" data-text="I just used Dwolla Here with <?php echo $DestinationName?>!" data-via="brettneese" data-size="large" data-count="none">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Flabs.brneese.com%2Fdwolla-here&amp;send=false&amp;layout=button_count&amp;width=75&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=528519203827913" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:75px; height:21px; text-alig: center;" allowTransparency="true"></iframe>            <h2> Thanks for using Dwolla Here! </h2>
            </div>
           
            <h2> <?php echo $timestamp; ?> </h2>
            <a href="./logout" data-role="button"> Logout </a>
          </div>
        </div>
    </body>
</html>​