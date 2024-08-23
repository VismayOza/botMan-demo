<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        html,
        body,
        #map {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Initialize map with a default view
        var map = L.map('map').setView([23.0225, 72.5714], 13); // Default to Ahmedabad

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Function to handle success of geolocation request
        function onLocationFound(e) {
            var lat = e.latitude;
            var lng = e.longitude;

            // Center map on user location
            map.setView([lat, lng], 13);

            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    var address = data.display_name;

                    // Add a marker for user location with address in the popup
                    L.marker([lat, lng]).addTo(map)
                        .bindPopup(`<strong>You are here</strong><br>${address}<br>Your Latitued :- ${lat}<br>Your Longitude :- ${lng}`)
                        .openPopup();
                })
                .catch(error => {
                    console.error('Error fetching address:', error);
                    // Fallback popup content in case of error
                    L.marker([lat, lng]).addTo(map)
                        .bindPopup("You are here")
                        .openPopup();
                });

        }

        // Function to handle error of geolocation request
        function onLocationError(e) {
            alert("Unable to retrieve your location.");
        }

        // Check if geolocation is supported
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                // Call onLocationFound with user's latitude and longitude
                onLocationFound({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                });
            }, onLocationError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    </script>
</body>

</html>
