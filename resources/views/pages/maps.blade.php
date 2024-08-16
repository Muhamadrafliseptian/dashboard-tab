<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps</title>
    <style>
        #map {
            height: 600px;
            /* Sesuaikan tinggi peta sesuai kebutuhan */
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="map"></div>

    <script>
        function initMap() {
            var location = {
                lat: -6.200000,
                lng: 106.816666
            }; // Koordinat Jakarta
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                title: 'Jakarta'
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYBzqp2zGPtI0xnr8N8nN_OjsxxzBB9nw&callback=initMap" async defer></script>
</body>

</html>
