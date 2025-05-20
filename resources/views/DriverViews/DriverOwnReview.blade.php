@extends('layouts.driverExterior')
@section('styelink')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
@section('content')
    <div class="container" style="margin-top: 20px; margin-bottom: 20px">
        <h1 style="margin-bottom: 20px">Your Reviews</h1>

        @foreach($reviews as $review)
            <div class="card mb-3 shadow-sm rounded" style="max-width: 600px;">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $review->client->userName}}</h5>
                    <p class="text-muted mb-2">
                        Rating {{$review->rating}}/5
                    </p>
                    <p class="card-text">{{ $review->ReviewDescription }}</p>
                    <small class="text-muted">Reviewed on {{ $review->created_at->format('M d, Y') }}</small>
                </div>
            </div>
        @endforeach


    </div>
@endsection
