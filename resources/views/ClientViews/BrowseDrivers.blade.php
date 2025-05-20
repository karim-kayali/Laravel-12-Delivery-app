@extends("layouts.userExterior2")

@section('content')

<div class="container py-5">
    <!-- Title Section -->
    <div class="text-center mb-4">
        <h2 class="display-4 text-white">Our Drivers</h2> <!-- White color for the title -->
        <p class="lead text-muted">Browse through our professional drivers</p>
    </div>

    <!-- Driver List Section -->
    <div class="row">
        @foreach($drivers as $driver)
        <div class="col-md-4 mb-4">
            <a href="{{ route('DriverDetails', $driver->id) }}" class="card text-decoration-none" style="border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    <h5 class="card-title" style="color: #304364;">{{ $driver->userName }}</h5> <!-- Custom color for the usernames -->
                    <p class="card-text"><strong>Email:</strong> {{ $driver->email }}</p>

                    <!-- Rating Stars -->
                    <p class="card-text"><strong>Rating:</strong>
                        @if($driver->reviews->isEmpty())
                            <span class="text-muted">No ratings yet</span>
                        @else
                            @php
                                $avgRating = $driver->reviews->avg('rating');
                                $fullStars = floor($avgRating); // Full stars
                                $halfStars = $avgRating - $fullStars >= 0.5 ? 1 : 0; // Half stars
                                $emptyStars = 5 - $fullStars - $halfStars; // Empty stars
                            @endphp

                            <!-- Full stars -->
                            @for($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star" style="color: gold;"></i>
                            @endfor

                            <!-- Half stars -->
                            @for($i = 0; $i < $halfStars; $i++)
                                <i class="fas fa-star-half-alt" style="color: gold;"></i>
                            @endfor

                            <!-- Empty stars -->
                            @for($i = 0; $i < $emptyStars; $i++)
                                <i class="far fa-star" style="color: #d3d3d3;"></i>
                            @endfor
                        @endif
                    </p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection
