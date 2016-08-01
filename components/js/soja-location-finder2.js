var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateMarkerStatus(str) {
  //document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {
  $('#lat').val(latLng.lat());
  $('#lng').val(latLng.lng());
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
  $('#location').val(str);
}

function updatepremiseradius(radius){
  $('.premise-radius').html(radius);
}

function initialize() {
  latLng = new google.maps.LatLng(Lat*1,Lng*1);
  ignore = false;
  map = new google.maps.Map(document.getElementById('gmap'), {
    zoom: 17,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  
  marker = new google.maps.Marker({
    position: latLng,
    title: '100 meters radius',
    map: map,
    icon:image,
    draggable: false
  });

  premiseCircle = new google.maps.Circle({
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35,
      map: map,
      center: {lat: Lat*1, lng: Lng*1},
      radius: 100,
      editable: true,
    });

  
  
  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
  
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
  
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });

  google.maps.event.addListener(premiseCircle, 'center_changed', function(){
        if (ignore){
            ignore = false;
            return;
        }
        premiseCircle.setEditable(false);
        ignore = true;
        premiseCircle.setCenter(latLng);
        premiseCircle.setEditable(true);
  });

  google.maps.event.addListener(premiseCircle,'mouseover',function(){
       this.getMap().getDiv().setAttribute('title','Premise Area');});

  google.maps.event.addListener(premiseCircle,'mouseout',function(){
       this.getMap().getDiv().removeAttribute('title');});

  google.maps.event.addListener(premiseCircle,'radius_changed',function(){
      marker.setTitle(Math.round(premiseCircle.getRadius())+' meters radius');
      updatepremiseradius(Math.round(premiseCircle.getRadius()));
      $('#input_premise_radius').val(Math.round(premiseCircle.getRadius()));
  });

}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);