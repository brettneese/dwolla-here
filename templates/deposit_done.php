<?php include 'head.php';?>
<body>
        <div data-role="page" data-theme="a">
        <div data-role="header" data-position="inline">
            <h1> Success! </h1>
            <a href="./list" data-icon="back">Back to list</a>
        </div>
        <div data-role="content" data-theme="a">
        <div id="sent">
            <h1> <?php echo $echo;?> </h1>
            <h2> Deposit $<?php echo $amount; ?> from "<?php echo $source_name?>"</h3>
            <h3>  Expected clear date:  </h3>
            <h3> <?php echo $clear_date; ?> </h3>
            <a href="./geo" data-role="button" rel="external"> Go home </a>
      </div>
    </div>
</body>
</html>​