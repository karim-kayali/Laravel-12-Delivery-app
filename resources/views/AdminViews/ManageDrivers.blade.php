@extends('layouts.adminExterior')
@section('stylelink')
    <link rel="stylesheet" href="{{asset("css/AdminCSS/admin.css")}}">
@endsection

@section('content')
<div class="container">

<h1>Manage Driver Applications</h1>

    <select name="status" id="statusSelect" style="color: black; margin-bottom: 20px; border-radius: 5px; padding: 2px" >
        <option disabled selected>Choose status</option>

        <option value="pending" >Pending</option>
        <option value="accepted">Accepted</option>
        <option value="rejected">Rejected</option>
    </select>

    <script>
        document.getElementById('statusSelect').addEventListener('change', function () {
            const status = this.value;
            window.location.href = `/manageDriverViewDrop/${status}`;
        });
    </script>

    @isset($message)
        <p>{{$message}}</p>
    @endisset

    @isset($status)
        <h2 style="color: white">{{ucfirst($status)}}</h2>
    @endisset
    @isset($drivers)
        <table class="table" style="color: white">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">UserName</th>
            <th scope="col">Email</th>
            @isset($status)
            @if($status == "pending")
            <th scope="col">Actions</th>
            @endif
            @endisset
        </tr>
        </thead>
        <tbody>

        @foreach($drivers as $driver)

        <tr onclick="window.location='{{ route('displayDriverDetails', ['id' =>$driver->id]) }}'" style="cursor: pointer;">
            <th scope="row">{{$driver->id}}</th>
            <td>{{$driver->userName}}</td>
            <td>{{$driver->email}}</td>
            @isset($status)
            @if($status=="pending")
            <td>
                <a class="btn btn-success" href="{{route('acceptDriver',["id" =>$driver->id])}}">Accept</a>
                <a class="btn btn-danger" href="{{route('rejectDriver',["id" =>$driver->id])}}">Reject</a>
            </td>
            @endif
            @endisset
        </tr>

        @endforeach

        </tbody>

    </table>
        @isset($emptyMessage)
            <p>{{$emptyMessage}}</p>
        @endisset
    @endisset
</div>
@endsection
