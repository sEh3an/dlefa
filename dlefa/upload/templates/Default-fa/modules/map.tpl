<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>
<div style='overflow:hidden;' class='map_resp'>
<div id='map'></div>
<style>#gmap_canvas img{max-width:none!important;background:none!important}</style>
</div>
<script type='text/javascript'>
function init_map(){
	var myOptions = {
			zoom:10,
			center: new google.maps.LatLng(35.6891975,51.388973599999986),
			mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById('map'), myOptions);
	
	marker = new google.maps.Marker({
		map: map,
		position: new google.maps.LatLng(35.6891975,51.388973599999986)
	});
	
	infowindow = new google.maps.InfoWindow({
		content:'<strong>همیار دیتالایف انجین</strong><br>تهران<br>'
	});
	
	google.maps.event.addListener(marker, 'click', function(){
		
		infowindow.open(map,marker);
	
	});
	
	infowindow.open(map,marker);
	
}

google.maps.event.addDomListener(window, 'load', init_map);
</script>