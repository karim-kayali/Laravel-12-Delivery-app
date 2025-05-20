@extends('layouts.UserExterior2')

@section('content')
    <div class="container mt-4">



        <form method="GET" action="{{ route('driverssearch') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search driver by name..." value="{{ request('search') }}" style="color: black">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>

            {{-- Keep the delivery data in the request --}}
            @foreach($data as $key => $value)
                @if($key !== 'availableDrivers' && $key !== 'search' && is_scalar($value))
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
        </form>

        <h2>AVAILABLE DRIVERS</h2>

        @if($data['availableDrivers']->isEmpty())
            <p>No drivers found matching your criteria.</p>
        @else
            <div class="row">
                @foreach($data['availableDrivers'] as $driver)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow border-0">
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title mb-3 text-primary">{{ $driver->userName }}</h3>

                                @php
                                    $priceStructure = $driver->priceStructure;
                                    $averageRating = $driver->reviews()->avg('rating') ?? 0;
                                @endphp

                                <h5 class="fw-bold mb-1" style="margin-top: 10px">Pricing Model</h5>

                                @if($priceStructure)
                                    <ul class="list-unstyled mb-3">
                                        <li>
                                            <i class="bi bi-box-seam me-1 text-secondary"></i>
                                            <strong>• Weight</strong> {{ $priceStructure->weightQuantity }} kg at {{ $priceStructure->weightPrice }}$
                                        </li>
                                        @if($priceStructure->fixedDistancePrice !== null)
                                            <li>
                                                <i class="bi bi-geo-alt-fill me-1 text-secondary"></i>
                                                <strong>• Fixed Distance Price</strong> {{ $priceStructure->fixedDistancePrice }}$
                                            </li>
                                        @elseif($priceStructure->distancePerKm !== null && $priceStructure->distancePrice !== null)
                                            <li>
                                                <i class="bi bi-map me-1 text-secondary"></i>
                                                <strong>• Distance</strong> {{ $priceStructure->distancePerKm }} km at <span style="font-weight: bolder">{{ $priceStructure->distancePrice }}$</span>
                                            </li>
                                        @else
                                            <li><em>No distance-based pricing specified.</em></li>
                                        @endif
                                    </ul>
                                @else
                                    <p><em>No pricing model available.</em></p>
                                @endif

                                <p class="fw-bold mb-3" style="margin-top: 10px">
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                    • Rating {{ number_format($averageRating, 1) }}/5
                                </p>

                                <form action="{{ route('PaymentPage') }}" method="GET" class="mt-auto">
                                    <input type="hidden" name="driver_id" value="{{ $driver->id }}">

                                    @foreach($data as $key => $value)
                                        @if($key !== 'availableDrivers' && is_scalar($value))
                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                        @endif
                                    @endforeach

                                    <button type="submit" class="btn btn-outline-primary w-100">Select Driver & Pay</button>
                                </form>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        @endif
    </div>
@endsection
