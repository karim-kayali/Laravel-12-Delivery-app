@php
    use Illuminate\Support\Facades\Auth;
        $layout = (!Auth::check() || Auth::user()->role_id == 1 ) ? 'layouts.userExterior2' : 'layouts.driverExterior';
@endphp

@extends($layout)
@section('content')
    <div class="container" style="margin-top: 20px">
        <h1>About Us</h1>
        <p class="aboutparag" style="line-height: 3">
            At Shipex, we believe delivery should be more than just getting from point A to point B—it should be fast,
            reliable, and tailored to your exact needs. As a full-service logistics provider, we offer a diverse fleet
            of motorcycles, cars, minivans, and trucks to handle every type of delivery, from urgent small parcels to
            large-scale commercial shipments.

            With over four decades of experience in the logistics and transportation industry, we’ve built a reputation
            as a trusted partner for businesses and individuals alike. Our deep understanding of local and regional
            delivery challenges allows us to provide smart, flexible solutions that keep your operations running
            smoothly.

            We take pride in our commitment to safety, precision, and on-time performance. Every package is handled with
            care, and every route is optimized for speed and efficiency. But we don’t stop there—our team continuously
            monitors trends, invests in technology, and adapts to evolving customer needs to stay one step ahead.

            At our core, we are problem-solvers. We see each delivery as a mission to exceed expectations—whether it’s a
            last-minute delivery across town or a scheduled freight drop for an industry leader. With transparent
            communication, real-time tracking, and a customer-first mindset, we make every delivery count.

            We don’t just move packages—we move trust. And we’re ready to move yours.
        </p>

    </div>
@endsection
