@extends('layouts.adminExterior')
@section('stylelink')
    <link rel="stylesheet" href="{{asset("css/AdminCSS/admin.css")}}">
@endsection
@section('content')

<div class="container">
    <a class="btn btn-danger" href="{{route('AdminCitiesView')}}">Back</a>
    <h1>Create City</h1>

    <form method="post" action="{{route('AdminCreateCity')}}">
        @csrf
        <div class="form-group">
            <label for="cityName" class="updateLabel">City Name</label>
            <input type="text" class="form-control updateInput bg-transparent text-white border border-white rounded-full px-4 py-2" id="cityName" placeholder="eg. Beirut" name="cityName">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>

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
