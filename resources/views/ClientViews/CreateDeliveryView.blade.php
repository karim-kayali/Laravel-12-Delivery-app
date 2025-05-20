@extends('layouts.UserExterior2')

@section('content')
    <style>


    </style>
    <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
        <h2>CREATE DELIVERY</h2>



        <form id="delivery-form" method="POST" action="{{ route('FilterDrivers') }}">
            @csrf

            <div class="form-group">
                <label for="deliveryDescription">Description</label>
                <textarea name="deliveryDescription" class="form-control text-dark bg-white" style="border-radius: 5px">{{ old('deliveryDescription') }}</textarea>
                @error('deliveryDescription')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="weightQuantity">Weight Quantity (kg)</label>
                <input type="number" name="weightQuantity" class="form-control text-dark bg-white "style="border-radius: 5px" value="{{ old('weightQuantity') }}">
                @error('weightQuantity')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="scheduledDeliveryDate">Scheduled Delivery Date</label>
                <input type="datetime-local" name="scheduledDeliveryDate" class="form-control text-dark bg-white"style="border-radius: 5px" value="{{ old('scheduledDeliveryDate') }}">
                @error('scheduledDeliveryDate')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Pick Pickup and Destination on the Map</label>
                <div style="position: relative;">
                    <button id="refresh-map-btn" type="button" class="btn btn-danger btn-sm"
                            style="position: absolute; top: 10px; right: 10px; z-index: 1000;">
                        Refresh Map
                    </button>
                    <div id="map" style="height: 400px;"></div>
                </div>
                @error('pickedFromX')
                <div class="text-danger">Pickup location is required.</div>
                @enderror
                @error('destinationX')
                <div class="text-danger">Destination location is required.</div>
                @enderror
            </div>

            <!-- Hidden Fields for Coordinates -->
            <input type="hidden" name="pickedFromX" id="pickedFromX" value="{{ old('pickedFromX') }}">
            <input type="hidden" name="pickedFromY" id="pickedFromY" value="{{ old('pickedFromY') }}">
            <input type="hidden" name="destinationX" id="destinationX" value="{{ old('destinationX') }}">
            <input type="hidden" name="destinationY" id="destinationY" value="{{ old('destinationY') }}">

            <!-- Hidden Fields for City Names -->
            <input type="hidden" name="pickupCity" id="pickupCity" value="{{ old('pickupCity') }}">
            <input type="hidden" name="destinationCity" id="destinationCity" value="{{ old('destinationCity') }}">

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Choose Driver</button>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([33.8938, 35.5018], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let pickupMarker = null;
        let destinationMarker = null;

        async function getCityName(lat, lon) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`, {
                    headers: { 'User-Agent': 'Mozilla/5.0' }
                });
                const data = await response.json();
                return data.address.city || data.address.town || data.address.village || 'Unknown';
            } catch {
                return 'Unknown';
            }
        }

        map.on('click', async function (e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            const city = await getCityName(lat, lng);

            if (!pickupMarker) {
                pickupMarker = L.marker(e.latlng, { draggable: true }).addTo(map);
                pickupMarker.bindPopup(`<b>Pickup:</b> ${city}`).openPopup();

                document.getElementById('pickedFromX').value = lat;
                document.getElementById('pickedFromY').value = lng;
                document.getElementById('pickupCity').value = city;

                pickupMarker.on('dragend', async function (e) {
                    const pos = e.target.getLatLng();
                    const newCity = await getCityName(pos.lat, pos.lng);
                    document.getElementById('pickedFromX').value = pos.lat;
                    document.getElementById('pickedFromY').value = pos.lng;
                    document.getElementById('pickupCity').value = newCity;
                    pickupMarker.setPopupContent(`<b>Pickup:</b> ${newCity}`).openPopup();
                });
            } else if (!destinationMarker) {
                destinationMarker = L.marker(e.latlng, { draggable: true }).addTo(map);
                destinationMarker.bindPopup(`<b>Destination:</b> ${city}`).openPopup();

                document.getElementById('destinationX').value = lat;
                document.getElementById('destinationY').value = lng;
                document.getElementById('destinationCity').value = city;

                destinationMarker.on('dragend', async function (e) {
                    const pos = e.target.getLatLng();
                    const newCity = await getCityName(pos.lat, pos.lng);
                    document.getElementById('destinationX').value = pos.lat;
                    document.getElementById('destinationY').value = pos.lng;
                    document.getElementById('destinationCity').value = newCity;
                    destinationMarker.setPopupContent(`<b>Destination:</b> ${newCity}`).openPopup();
                });
            }
        });

        document.getElementById('refresh-map-btn').addEventListener('click', function () {
            if (pickupMarker) {
                map.removeLayer(pickupMarker);
                pickupMarker = null;
            }
            if (destinationMarker) {
                map.removeLayer(destinationMarker);
                destinationMarker = null;
            }

            // Clear hidden inputs
            document.getElementById('pickedFromX').value = '';
            document.getElementById('pickedFromY').value = '';
            document.getElementById('destinationX').value = '';
            document.getElementById('destinationY').value = '';
            document.getElementById('pickupCity').value = '';
            document.getElementById('destinationCity').value = '';
        });


    </script>
@endsection
