@extends('layouts.userExterior2')

@section('content')
    <script>
        const isDriver = {{ $isDriver ? 'true' : 'false' }};
    </script>

    <div id="map" style="height: 70vh; width: 100%; margin: 30px 0px"></div>

    <script>
        let map, marker;
        let blueRenderer, redRenderer;
        let lastDriverPosition = null;
        let animationFrame;

        const stopLocation = { lat: {{$delivery->pickedFromX}}, lng: {{$delivery->pickedFromY}} }; // Pickup
        const destinationLocation = { lat: {{$delivery->destinationX}},  lng: {{$delivery->destinationY}} }; // Dropoff

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: destinationLocation,
            });

            // Show real-time traffic
            const trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(map);

            const directionsService = new google.maps.DirectionsService();

            blueRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true,
                preserveViewport: true,
                polylineOptions: {
                    strokeColor: '#0000FF',
                    strokeOpacity: 0.7,
                    strokeWeight: 5,
                    zIndex: 1000
                }
            });

            redRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true,
                preserveViewport: true,
                polylineOptions: {
                    strokeColor: '#000000',
                    strokeOpacity: 0.8,
                    strokeWeight: 4,
                    zIndex: 500
                }
            });

            new google.maps.Marker({
                position: destinationLocation,
                map: map,
                label: {
                    text: 'D',
                    color: "white",
                    fontSize: "24px",
                    fontWeight: "bold"
                },
                title: "Destination",
            });

            new google.maps.Marker({
                position: stopLocation,
                map: map,
                label: {
                    text: 'P',
                    color: "white",
                    fontSize: "24px",
                    fontWeight: "bold"
                },
                title: "Pickup Location",
            });

            function updateBlueRoute(currentPos) {
                directionsService.route({
                    origin: currentPos,
                    destination: destinationLocation,
                    travelMode: google.maps.TravelMode.DRIVING,
                    drivingOptions: {
                        departureTime: new Date(),
                        trafficModel: 'bestguess'
                    }
                }, (result, status) => {
                    if (status === google.maps.DirectionsStatus.OK) {
                        blueRenderer.setDirections(result);
                    }
                });
            }

            function updateRedRoute(currentPos) {
                directionsService.route({
                    origin: currentPos,
                    destination: stopLocation,
                    travelMode: google.maps.TravelMode.DRIVING,
                    drivingOptions: {
                        departureTime: new Date(),
                        trafficModel: 'bestguess'
                    }
                }, (result, status) => {
                    if (status === google.maps.DirectionsStatus.OK) {
                        redRenderer.setDirections(result);
                    }
                });
            }

            function animateMarker(toPosition) {
                const deltaLat = (toPosition.lat - lastDriverPosition.lat) / 60;
                const deltaLng = (toPosition.lng - lastDriverPosition.lng) / 60;
                let i = 0;

                cancelAnimationFrame(animationFrame);

                function move() {
                    i++;
                    const lat = lastDriverPosition.lat + deltaLat * i;
                    const lng = lastDriverPosition.lng + deltaLng * i;
                    const newPos = { lat, lng };
                    marker.setPosition(newPos);
                    map.setCenter(newPos);

                    if (i < 60) {
                        animationFrame = requestAnimationFrame(move);
                    } else {
                        lastDriverPosition = toPosition;
                    }
                }
                move();
            }

            function updateDriver(currentPos) {
                if (!marker) {
                    marker = new google.maps.Marker({
                        position: currentPos,
                        map: map,
                        icon: {
                            url: 'http://maps.google.com/mapfiles/kml/shapes/cabs.png',
                            scaledSize: new google.maps.Size(30, 30),
                        },
                        title: "Driver",
                    });
                    lastDriverPosition = currentPos;
                } else {
                    animateMarker(currentPos);
                }

                updateBlueRoute(currentPos);
                updateRedRoute(currentPos);
            }

            if (isDriver && navigator.geolocation) {
                navigator.geolocation.watchPosition(
                    (position) => {
                        const currentPos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        updateDriver(currentPos);

                        fetch('/api/update-driver-location', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify(currentPos),
                        });
                    },
                    (err) => alert("Geolocation error: " + err.message),
                    {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                );
            } else {
                setInterval(() => {
                    fetch('/api/get-driver-location')
                        .then(res => res.json())
                        .then(driverPos => {
                            const pos = { lat: driverPos.lat, lng: driverPos.lng };
                            updateDriver(pos);
                        });
                }, 5000);
            }
        }
    </script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap">
    </script>
@endsection
