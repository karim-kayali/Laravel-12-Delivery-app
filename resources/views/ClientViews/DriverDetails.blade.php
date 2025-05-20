@extends("layouts.userExterior2")

@section('stylelink')
    <link rel="stylesheet" href="{{ asset("css/UserCSS/DriverDetails.css") }}">
@endsection

@section('content')

<div class="container py-5 container-white-bg">
    <a class="btn btn-danger" href="{{route('BrowseDrivers')}}">Back</a>

    <!-- Title Section -->
    <div class="text-center mb-4">
        <h2 class="display-4">{{ $driver->userName }}'s Profile</h2>
        <p class="lead text-muted">View and leave a review for this professional driver</p>
    </div>

    <!-- Driver Information -->
    <div class="row mb-5">
        <div class="col-md-6">
            <p><strong>Email:</strong> {{ $driver->email }}</p>
            <p><strong>Phone:</strong> {{ $driver->phoneNumber }}</p>
            <p><strong>Vehicle:</strong> {{ $driver->vehicleType }} - {{ $driver->vehicleModel }}</p>
        </div>
    </div>

    <!-- Reviews Section -->
    <h3 class="mb-4">Reviews</h3>
    @forelse($reviews as $review)
        <div class="card mb-3 card-white-bg">
            <div class="card-body">
            <h5 class="card-title">
    {{ $review->client->userName }}
    @for ($i = 1; $i <= 5; $i++)
        @if ($review->rating >= $i)
            <i class="fas fa-star"></i>
        @elseif ($review->rating >= $i - 0.5)
            <i class="fas fa-star-half-alt"></i>
        @else
            <i class="far fa-star"></i>
        @endif
    @endfor
</h5>
                <p class="card-text">{{ $review->ReviewDescription }}</p>
            </div>
        </div>
    @empty
        <p class="text-muted">No reviews yet.</p>
    @endforelse

    <!-- Leave a Review Section -->
    <h3 class="mb-4">Leave a Review</h3>
    <form method="POST" action="{{ route('DriverReview', $driver->id) }}">
        @csrf
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <input type="number" name="rating" min="1" max="5" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="review_text" class="form-label">Review</label>
            <textarea name="review_text" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

@endsection
