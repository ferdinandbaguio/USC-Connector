<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}">
    <title>Places Search Box</title>
    <style>
      
    </style>
  </head>
  <body onload="mapofJonas();">
    <div class="container">
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map" style="height:400px;display: none;"></div>

    <label class="mt-5">LATITUDE</label>
    <input type="text" id="latitudeData" readonly>
    <label>LONGITUDE</label>
    <input type="text" id="lngData" readonly>
    <h3> WELL JONAS IS HANDSOME </h3>
    </div>


    <!-- <div class="container">
      <div id="map2" class="w-100 bg-dark" style="height: 400px;">
        </div>
        <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlyUWOZTrGwtkrOFAV6-ejOmll5VuhUbE&callback=initMap">
        </script>
        <script>
            // Initialize and add the map
            function initMap() {
             var lettucey = 10.3540762;
             var lettucey2 = 123.91157580000004;
            // The location of San Carlos
            var SanCarlosTalamban = {lat: lettucey, lng: lettucey2};
            // The map, centered at San Carlos
            var map2 = new google.maps.Map(
                document.getElementById('map2'), {zoom: 17, center: SanCarlosTalamban});
            // The marker, positioned at San Carlos
            var marker = new google.maps.Marker({position: SanCarlosTalamban, map2: map2});
            }
        </script>
    </div> -->



    <script>
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function mapofJonas() {
        var lettucey = 10.3540762;
        var lettucey2 = 123.91157580000004;
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: lettucey, lng: lettucey2},
          zoom: 18,
          mapTypeId: 'roadmap'
        });
        

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            // JONAS JONAS JONAS
            locationChosen = place.geometry.location;
            var latitudeData = locationChosen.lat();
            var lngData = locationChosen.lng();
            document.getElementById("latitudeData").value = latitudeData;
            document.getElementById("lngData").value = lngData;




            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtg-XSKJw7nLDyIan_k_FD2z8vdlIczvY&libraries=places&callback=mapofJonas"
         async defer></script>
  </body>
</html>