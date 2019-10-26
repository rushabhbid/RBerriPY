<?php
session_start();

include_once("includes/connection.php");
include_once("includes/functions.php");

if(!isset($_SESSION['loggedInUser'])){
    //send the iser to login page
    header("location:home.php");
}
?>
<!DOCTYPE html>
<html>
<style>
  /* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
  #map {
    height: 40%;
    width:50%;
  }

</style>


<body>
  <div id="map"></div>
  <script>
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.
    var map, infoWindow;
    function initMap() {


      infoWindow = new google.maps.InfoWindow;





      // Try HTML5 geolocation.
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          map = new google.maps.Map(document.getElementById('map'), {
            center: {lat:pos["lat"], lng:pos["lng"]},
            zoom: 15
          });
          var marker = new google.maps.Marker({
          position:  {lat:pos["lat"], lng:pos["lng"]},
          map: map,
          draggable:true,
          title: 'Location'
          });


        }, function() {
          handleLocationError(true, infoWindow, map.getCenter());
        });
      } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
      }



      google.maps.event.addListener(
                marker,
                'drag',
                function() {
                  document.getElementById("lat").value =marker.position.lat().toFixed(6);
      document.getElementById("lon").value =marker.position.lng().toFixed(6);
                }
            );
      document.getElementById("lat").value =marker.position.lat().toFixed(6);
      document.getElementById("lon").value =marker.position.lng().toFixed(6);



    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
      infoWindow.setPosition(pos);
      infoWindow.setContent(browserHasGeolocation ?
                            'Error: The Geolocation service failed.' :
                            'Error: Your browser doesn\'t support geolocation.');
      infoWindow.open(map);
    }

  </script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqiw5rHS-tYwkJie9sJAWfGX7Ig8ystI8&callback=initMap">
  </script>


<form action="issueback.php" method="POST">
<p>Type of Issue:</p>
  <select value="type" name="type">
      <option value="electricity">Electricity</option>
    <option value="water">Water</option>
    <option value="Traffic">Traffic</option>
    <option value="roads">Roads</option>
    <option value="garbage">Garbage</option>
      <option value="misc">Miscellaneous</option>
  </select>
  <br>
  <br>
<p>Severity</p>
    <input type="number" name="sev" min="1" max="5">
<br>
<br>

<p>Ward:</p>
 <input type="text" name="username"><br><br>

<p>Description</p>
  <textarea name="desc" id="desc"rows="10" cols="30">

  </textarea>
<br><br>
<input type="hidden" name="lat"  id="lat" value="" />
<input type="hidden" name="lon"   id="lon" value="" />

    <input type="submit" value="Submit">

</form>
</body>
</html>