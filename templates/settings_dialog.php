<?php include 'head.php';?>
<div data-role="page">

	<a href="javascript:$('.ui-dialog').dialog('close')" data-role="header" data-position="inline" style="text-decoration: none; color: #333333; ">
		<h1> Options </h1>
	</a>
	<div data-role="content" class="ui-body-a">
		
	<?	echo "<a href='http://labs.brneese.com/dwolla-here/contacts' data-role='button'> Dwolla Contacts </a>";
		echo "<a href='http://labs.brneese.com/dwolla-here/list' data-role='button'> Dwolla Merchants Near Me </a>";
	?>
			
	<a href='http://labs.brneese.com/dwolla-here/deposit' data-role='button'> Deposit </a>
	<a href='http://labs.brneese.com/dwolla-here/withdraw' data-role='button'> Withdraw </a>
	<a href="logout" data-role="button"> Logout </a>

	</div>
</body>
</html>