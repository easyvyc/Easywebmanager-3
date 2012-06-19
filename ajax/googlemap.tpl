<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps JavaScript API Example</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key={xml_config.google_map_code}&sensor=true" type="text/javascript"></script>
    <script type="text/javascript">

	var value = '<block name="get.value">{get.value}</block name="get.value">';
	var arr = value.split('::');
    function initialize() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map_canvas"));
        if(value!=''){
        	center = new GLatLng(arr[0], arr[1]);
        	map.setCenter(center, parseInt(arr[2]));
        	addMarker(new GLatLng(arr[3], arr[4]));
        }else{
        	center = new GLatLng({xml_config.googlemaps_centerlat}, {xml_config.googlemaps_centerlon});
        	map.setCenter(center, {xml_config.googlemaps_zoom});
        	addMarker(center);
        }
        map.setUIToDefault();
        map.enableGoogleBar();
        //GEvent.addListener(map, "dragend", setGMapValue()); 
        //GEvent.addListener(map, "zoomend", setGMapValue()); 
      }
    }
    
    function Map_Drag(){
		var point = map.getCenter() ;
    }
    
    function addMarker(coords){
        marker = new GMarker(coords, {draggable: true});
 
        GEvent.addListener(marker, "dragstart", function() {
          map.closeInfoWindow();
        });
 
        GEvent.addListener(marker, "dragend", setGMapValue);
 
        map.addOverlay(marker);    	
    }
    
    function setGMapValue(){
          map_pos = map.getCenter();
          marker_pos = marker.getPoint();
          str = ''+map_pos.lat().toString()+'::'+map_pos.lng().toString()+'::'+map.getZoom().toString()+'::'+marker_pos.lat().toString()+'::'+marker_pos.lng().toString();
          parent.document.getElementById('{get.column}').value=str;
    }

    </script>
  </head>
  <body onload="initialize()" onunload="GUnload()" style="margin:0px;background:#F2F2F2;">
    <div id="map_canvas" style="width: 400px; height: 300px"></div>
    
  </body>
</html>