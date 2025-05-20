@extends('layouts.DriverExterior')

@section('content')
    <style>
        select#status {
            font-size: 14px;
            padding: 5px 10px;
            width: 180px;
            height: 35px;
            border-radius: 5px;
            background-color: #f8f9fa;
            color: #000;
            margin-top: 10px; /* Lowered dropdown */
        }

        label[for="status"] {
            font-size: 18px;
            font-weight: bold;
            margin-right: 10px;
        }

        tr:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }
    </style>

    <div class="container">
        @php
            // Get the current status from the request, default to 'pending' if not provided
            $status = request('status', 'pending');
            $title = ucfirst($status) . ' Deliveries';
        @endphp

        <h1 class="my-4">{{ $title }}</h1>

        {{-- Status Filter --}}
        <form method="GET" action="" class="mb-4">
            <div class="form-group d-flex align-items-center mt-3">
                <label for="status">Filter Status:</label>
                <select name="status" id="status" onchange="this.form.submit()">
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accepted" {{ $status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
        </form>

        {{-- Total Revenue --}}
        @if($status === 'completed' && $pendingDeliveries->isNotEmpty())
            <div class="alert alert-success fw-bold">
                Total Revenue: ${{ number_format($totalPrice, 2) }}
            </div>
        @endif

        {{-- Deliveries Table --}}
        @if($pendingDeliveries->isEmpty())
            <div class="alert alert-info">No {{ $status }} deliveries found.</div>
        @else
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                <tr>
                    <th>Weight</th>
                    <th>Delivered To</th>
                    <th>Pick Up</th>
                    <th>Destination</th>
                    <th>Total Distance Price</th>
                    <th>Scheduled Delivery Date</th>
                    @if($status === 'completed') <th>Total Price</th> @endif
                    @if($status === 'pending') <th>Actions</th> @endif
                </tr>
                </thead>
                <tbody>
                @foreach($pendingDeliveries as $delivery)
                    <tr onclick="window.location='{{ route('deliveries.details', $delivery->id) }}'">
                        <td>{{ $delivery->weightQuantity }} Kg</td>
                        <td>{{ $delivery->deliveredToUser->userName }}</td>
                        <td id="pickedFromCity{{ $delivery->id }}">Loading...</td>
                        <td id="destinationCity{{ $delivery->id }}">Loading...</td>
                        <td>{{ $delivery->totalDistancePrice }} $</td>
                        <td>{{ \Carbon\Carbon::parse($delivery->scheduledDeliveryDate)->format('M d, Y') }}</td>

                        @if($status === 'completed')
                            <td>{{ number_format($delivery->totalDeliveryPrice, 2) }} $</td>
                        @endif

                        @if($status === 'pending')
                            <td>
                                @if(optional($delivery->request)->requestStatus === 'pending')
                                    <form method="POST" action="{{ route('deliveries.accept', $delivery->id) }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('deliveries.reject', $delivery->id) }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
    @if(session('refresh_deliveries'))
        <script>
            window.location.reload(); // Reload the page to show the updated delivery status
        </script>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Function to get the city name from lat, lon
            async function getCityName(lat, lon) {
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`, {
                        headers: { 'User-Agent': 'Mozilla/5.0' }
                    });
                    const data = await response.json();
                    const address = data.address || {};
                    return address.city || address.town || address.village || address.suburb || address.state || address.country || 'Unknown';
                } catch (error) {
                    console.error("Error fetching city:", error);
                    return 'Unknown';
                }
            }

            // Function to update cities in the table
            async function updateCities(deliveryId, pickedLat, pickedLon, destLat, destLon) {
                if (!isNaN(pickedLat) && !isNaN(pickedLon)) {
                    const picked = await getCityName(pickedLat, pickedLon);
                    document.getElementById(`pickedFromCity${deliveryId}`).textContent = picked;
                }

                if (!isNaN(destLat) && !isNaN(destLon)) {
                    const dest = await getCityName(destLat, destLon);
                    document.getElementById(`destinationCity${deliveryId}`).textContent = dest;
                }
            }

            // Loop through the deliveries and update their city information
            const deliveries = @json($pendingDeliveries);
            deliveries.forEach(delivery => {
                const pickedLat = parseFloat(delivery.pickedFromX);  // Switched X and Y
                const pickedLon = parseFloat(delivery.pickedFromY);  // Switched X and Y
                const destLat = parseFloat(delivery.destinationX);  // Switched X and Y
                const destLon = parseFloat(delivery.destinationY);  // Switched X and Y

                updateCities(delivery.id, pickedLat, pickedLon, destLat, destLon);
            });
        });
    </script>

@endsection
