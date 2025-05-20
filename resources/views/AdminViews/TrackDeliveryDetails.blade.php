@extends('layouts.adminExterior')

@section('stylelink')
    <link rel="stylesheet" href="{{asset("css/AdminCSS/admin.css")}}">
@endsection
@section('content')
    <div class="container">
        <a class="btn btn-danger" href="{{route("adminTrackDeliveriesView")}}" style="margin-bottom: 25px">Back</a>

        <h1 style="margin-bottom: 20px;">Delivered by {{strtoupper($delivery->deliveredByUser->userName)}}</h1>
        <p>Delivered To <b>{{$delivery->deliveredToUser->userName}}</b></p>
        <p>Should be Delivered on <b>{{ \Carbon\Carbon::parse($delivery->scheduledDeliveryDate)->format('Y-m-d') }}</b> at <b>{{ \Carbon\Carbon::parse($delivery->scheduledDeliveryDate)->format('h:i A') }}</b></p>
        <p>Delivery Description: <b>{{$delivery->deliveryDescription}}</b></p>
        <p>Delivery Weight: <b>{{$delivery->weightQuantity}}</b></p>
        <p>Total Weight Price: <b>{{round($delivery->totalWeightPrice, 2)}}$</b></p>
        <p>Total Distance Price: <b>{{round($delivery->totalDistancePrice,2)}}$</b></p>
        <p>Total Delivery Price: <b>{{round($delivery->totalDeliveryPrice,2)}}$</b></p>


    </div>
@endsection

