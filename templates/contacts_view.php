<?php include 'head.php';?>
	<div data-role="page" data-theme="a">
		<a href="./settings" data-rel="dialog" data-transition="slidedown">
		<div data-role="header" data-position="fixed"> 
			<h1>Dwolla Here</h1>
	</div></a>

	<div data-role="content" data-theme="a">
		<ul data-role="listview" data-filter="true">
			<?php
			foreach ($contact_array as $contact ) {
				$name = $contact['Name'];
				$id = $contact['Id'];
				echo  "<li><a href=id/$id>$name</a></li>";
			}
			?>
		</ul>
	</div>
<div class="footer_links">
	<center> Your current Dwolla balance is $<?php echo $balance?>. </center> </br>
	<center> Not seeing the Dwolla merchant you're looking for? </a> </center>
	<center> <a href="./custom"> You can also enter their Dwolla ID manually.</a> </center>
	</br>
	<center> <a href="./contacts" rel="external" data-icon="refresh" data-role="button">Refresh This List</a> </center>
	 </br> </br>
	</div>
</div>
</div>
</body>
</html>