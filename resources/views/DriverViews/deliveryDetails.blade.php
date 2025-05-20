@extends('layouts.DriverExterior')

@section('content')
    <div class="container">
        <h1 class="my-4">Delivery Details</h1>

        <div class="card">
            <div class="card-body">
                <p><strong>Description:</strong> {{ $delivery->deliveryDescription }}</p>
                <p><strong>Weight Quantity:</strong> {{ $delivery->weightQuantity }}</p>
                <p><strong>Total Weight Price:</strong> {{ $delivery->totalWeightPrice }}</p>
                <p><strong>Total Distance Price:</strong> {{ $delivery->totalDistancePrice }}</p>
                <p><strong>Total Delivery Price:</strong> {{ $delivery->totalDeliveryPrice }}</p>
                @if(empty($delivery->discount))
                    <p><strong>Discount:</strong> No discount applied for this delivery</p>
                @else
                    <p><strong>Discount:</strong> {{ $delivery->discount }}%</p>
                @endif


                {{-- Actual Location Info --}}
                <p><strong>Picked From:</strong> <span id="pickedFromCity">Loading...</span></p>
                <p><strong>Destination:</strong> <span id="destinationCity">Loading...</span></p>

                <p><strong>Scheduled Delivery Date:</strong> {{ $delivery->scheduledDeliveryDate }}</p>
                <p><strong>Delivered To:</strong> {{ optional($delivery->deliveredToUser)->userName ?? 'N/A' }}</p>
                <p><strong>Delivered By:</strong> {{ optional($delivery->deliveredByUser)->userName ?? 'N/A' }}</p>
                <p><strong>Request Status:</strong> {{ optional($delivery->request)->requestStatus ?? 'N/A' }}</p>

            </div>
        </div>

        <a href="{{ route('deliveries.pending') }}" class="btn btn-secondary mt-3">Back to Pending Deliveries</a>

    </div>

    <script>
        // Function to get city name using reverse geocoding
        async function getCityName(lat, lon) {
            try {
                const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;
                const response = await fetch(url, {
                    headers: { 'User-Agent': 'Mozilla/5.0' }
                });
                const data = await response.json();
                console.log("Reverse Geocoding Response:", data);

                if (data && data.address) {
                    const address = data.address;
                    // Return the most specific address component available
                    return address.neighbourhood || address.suburb || address.village || address.town || address.city_district || address.city || address.state || address.country || 'Unknown';
                }
                return 'Unknown';
            } catch (err) {
                console.error("Fetch Error:", err);
                return 'Unknown';
            }
        }

        document.addEventListener('DOMContentLoaded', async () => {
            // Ensure coordinates are properly parsed as float
            const pickedFromLat = parseFloat("{{ $delivery->pickedFromY ?? 'null' }}");
            const pickedFromLon = parseFloat("{{ $delivery->pickedFromX ?? 'null' }}");
            const destinationLat = parseFloat("{{ $delivery->destinationY ?? 'null' }}");
            const destinationLon = parseFloat("{{ $delivery->destinationX ?? 'null' }}");


            // Check if coordinates are valid and make the API call to get city names
            if (!isNaN(pickedFromLat) && !isNaN(pickedFromLon)) {
                const pickedCity = await getCityName(pickedFromLon, pickedFromLat);
                document.getElementById('pickedFromCity').textContent = pickedCity;
            } else {
                document.getElementById('pickedFromCity').textContent = 'Unknown';
            }

            if (!isNaN(destinationLat) && !isNaN(destinationLon)) {
                const destinationCity = await getCityName(destinationLon, destinationLat);
                document.getElementById('destinationCity').textContent = destinationCity;
            } else {
                document.getElementById('destinationCity').textContent = 'Unknown';
            }
        });
    </script>
@endsection
