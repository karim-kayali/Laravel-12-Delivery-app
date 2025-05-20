@extends('layouts.UserExterior2')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Pending Delivery Requests</h2>

        @if($pendingDeliveries->isEmpty())
            <div class="alert alert-info">No pending deliveries found.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                    <tr>


                        <th>Weight (kg)</th>
                        <th>Total Price ($)</th>
                        <th>Scheduled Date</th>
                        <th>Delivered To</th>
                        <th>Delivered By</th>
                        <th>Request Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pendingDeliveries as $delivery)
                        <tr>


                            <td>{{ $delivery->weightQuantity }}</td>
                            <td>{{ $delivery->totalDeliveryPrice }}</td>
                            <td>{{ \Carbon\Carbon::parse($delivery->scheduledDeliveryDate)->format('Y-m-d H:i') }}</td>
                            <td>{{ $delivery->deliveredToUser->userName ?? 'N/A' }}</td>
                            <td>{{ $delivery->deliveredByUser->userName ?? 'N/A' }}</td>

                            <td>
                                @if($delivery->request)
                                    <span class="badge
               @if($delivery->request->requestStatus === 'pending') bg-warning text-dark
              @elseif($delivery->request->requestStatus === 'accepted') bg-success
              @elseif($delivery->request->requestStatus === 'denied') bg-danger
               @endif">
              {{ ucfirst($delivery->request->requestStatus) }}
        </span>
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
