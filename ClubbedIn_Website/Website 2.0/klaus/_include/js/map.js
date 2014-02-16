jQuery(document).ready(function($){
if($('.map').length > 0)
	{

		$('.map').each(function(i,e){

			$map = $(e);
			$map_id = $map.attr('id');
			$map_lat = $map.attr('data-mapLat');
			$map_lon = $map.attr('data-mapLon');
			$map_zoom = parseInt($map.attr('data-mapZoom'));
			$map_title = $map.attr('data-mapTitle');
			$map_marker_img = $map.attr('data-marker-img');
			$map_info = $map.attr('data-info');
			
			
			
			var latlng = new google.maps.LatLng($map_lat, $map_lon);			
			var options = { 
				scrollwheel: false,
				draggable: false, 
				zoomControl: false,
				disableDoubleClickZoom: false,
				disableDefaultUI: true,
				zoom: $map_zoom,
				center: latlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			
			var styles = [ 
							{
								stylers: [
								  { hue: "" }, // Inser Your Hue Color
								  { saturation: -100 },
								  { lightness: 0 }
								]
							  },{
								featureType: "road",
								elementType: "geometry",
								stylers: [
								  { lightness: 50 },
								  { saturation: 0 },
								  { visibility: "simplified" }
								]
							  },{
								featureType: "road",
								elementType: "labels",
								stylers: [
								  { visibility: "on" }
								]
							  }
						];
			
			var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});
			
			var map = new google.maps.Map(document.getElementById($map_id), options);
		
			var image = $map_marker_img;
			var marker = new google.maps.Marker({
				position: latlng,
				map: map,
				title: $map_title,
				icon: image
			});
			
			map.mapTypes.set('map_style', styledMap);
  			map.setMapTypeId('map_style');
			
			var contentString = $map_info;
       
			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});
			
			google.maps.event.addListener(marker, 'click', function() {
      			infowindow.open(map,marker);
    		});

		});
	}
});
