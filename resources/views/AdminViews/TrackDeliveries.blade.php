@extends('layouts.adminExterior')
@section('stylelink')
    <link rel="stylesheet" href="{{asset("css/AdminCSS/admin.css")}}">
@endsection

@section('content')
    <div class="container">

        <h1>Track Deliveries</h1>

{{--        <form method="get" action="{{ route('adminTrackDeliveriesViewDrop') }}">--}}
{{--            @csrf--}}
            <select id="requestStatus" name="requestStatus" style="color: black; margin-bottom: 20px; border-radius: 5px; display: inline; background-color: white">
                <option value="">Choose Request Type</option>
                <option value="pending">Pending</option>
                <option value="accepted">Accepted</option>
                <option value="denied">Denied</option>
                <option value="inProgress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        <script>
            document.getElementById('requestStatus').addEventListener('change', function () {
                const status = this.value;
                window.location.href = `/adminTrackDeliveriesViewDrop/${status}`;
            });
        </script>

{{--            <select name="deliveryStatus" style="color: black; margin-bottom: 20px; border-radius: 5px; display: inline; background-color: white">--}}
{{--                <option value="" selected>Choose Status Type</option>--}}
{{--                <option value="inProgress">In Progress</option>--}}
{{--                <option value="completed">Completed</option>--}}
{{--            </select>--}}

{{--            <button type="submit" class="btn btn-primary" style="margin-left: 10px">Apply</button>--}}
{{--        </form>--}}


        @isset($message)
            <p>{{$message}}</p>
        @endisset

        @isset($request)
            <h2 style="color: white">{{ucfirst($request)}}</h2>
        @endisset

        @isset($deliveries)
            <table class="table" style="color: white">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Delivery Due Date</th>
                    <th scope="col">Delivered By</th>
                    <th scope="col">Delivered To</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>

                @foreach($deliveries as $delivery)

                    <tr onclick="window.location='{{ route('displayDeliveryDetails', ['id' =>$delivery->id]) }}'" style="cursor: pointer;">
                        <th scope="row">{{$delivery->id}}</th>
                        <td>{{ \Carbon\Carbon::parse($delivery->scheduledDeliveryDate)->format('F j, Y \a\t h:i A') }}</td>
                        <td>{{$delivery->deliveredByUser->userName}}</td>
                        <td>{{$delivery->deliveredToUser->userName}}</td>
                        @if(isset($delivery->statuses))
                        <td>{{$delivery->statuses->deliveryStatus}}</td>
                        @else
                            <td>None</td>
                        @endif
                    </tr>

                @endforeach

                </tbody>

            </table>
            @isset($emptyRequestMessage)
                <p>{{$emptyRequestMessage}}</p>
            @endisset
        @endisset


    </div>
@endsection
