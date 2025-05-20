@extends('layouts.adminExterior')

@section('stylelink')
    <link rel="stylesheet" href="{{asset("css/AdminCSS/admin.css")}}">
@endsection
@section('content')
    <div class="container">
        <a class="btn btn-danger" href="{{route("indexAdmin")}}" style="margin-bottom: 25px">Back</a>

        <h1 style="margin-bottom: 20px; text-decoration: underline">{{$driver->userName}}</h1>
        <p>Email: <b>{{$driver->email}}</b></p>
        <p>Phone Number: <b>{{$driver->phoneNumber}}</b></p>
        <p>Vehicle Type: <b>{{$driver->vehicleType}}</b></p>
        <p>Vehicle Model: <b>{{$driver->vehicleModel}}</b></p>
        <p>Plate Number: <b>{{$driver->plateNumber}}</b></p>
        <p>Applied in <b>{{ \Carbon\Carbon::parse($driver->created_at)->format('F j, Y \a\t h:i A') }}</b></p>
        <p>Shift from <b>{{ \Carbon\Carbon::parse($driver->startShift)->format('h:i A') }}</b>
            <b>till {{ \Carbon\Carbon::parse($driver->endShift)->format('h:i A') }}
            </b></p>

    </div>
@endsection
