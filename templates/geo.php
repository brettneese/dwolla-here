
<html>
<head>
	<title>Getting your location...</title>
	<script src="js/geo-min.js" type="text/javascript" charset="utf-8"></script>
	<script src="http://code.jquery.com/jquery.min.js" type="text/javascript" charset="utf-8"></script>
</head>	
<body>

<script type="text/javascript">
//GOOGLE ANALYTICS
</script>

<b>Hold up one second...</b>

<script> 
//alert("Note: Dwolla Here is currently under construction and probably all kinds of broken right now. Yes, there are better ways to do this. But, for now, please don't mind our dust.");
</script>
<script>
	if(geo_position_js.init()){
		geo_position_js.getCurrentPosition(success_callback,error_callback,{enableHighAccuracy:true});
	}
	else{
		alert("Functionality not available");
	}

	function success_callback(p)
	{
			lat = p.coords.latitude.toFixed(2);
			lon= p.coords.longitude.toFixed(2);

			var url = 'http://labs.brneese.com/dwolla-here/';
			var form = $('<form action="' + url + '" method="get">' +
				'<input type="hidden" name="lat" value="' + lat + '" />' +
				'<input type="hidden" name="lon" value="' + lon + '" />' +

				'</form>');
	$('body').append(form);
	$(form).submit();
	}

	function error_callback(p)
	{
		window.location.replace("http://labs.brneese.com/dwolla-here/geo_fail");
	}		
</script>
</body>
</html>