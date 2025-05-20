@extends('layouts.adminExterior')

@section('content')
    <div class="container">
        <h1>Available Cities To Serve</h1>
        <a class="btn btn-success" href="{{route('AdminCreateCityView')}}">Create</a>
        <form>
            <input type="text"  style="width: 500px; margin-top: 15px" class="form-control updateInput bg-transparent text-white border border-white rounded px-4 py-2" id="cityName" placeholder="Search City" name="cityName">
        </form>

        <table class="table" style="color: white">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">City</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($cities))

            @foreach($cities as $city)
            <tr>
                <th scope="row">{{$city->id}}</th>
                <td>{{$city->cityName}}</td>
                <td>
                    <a class="btn btn-warning" href="{{route('AdminEditCityView', ["id"=>$city->id])}}">Edit</a>
                    <form style="display: inline" method="post" action="{{route('AdminDeleteCity', ["id" => $city->id])}}">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>

                </td>
                @endforeach
            </tr>
            @endif
            </tbody>
        </table>
        <script>
            document.getElementById('cityName').addEventListener('input', function () {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll('table tbody tr');

                rows.forEach(function (row) {
                    const cityCell = row.querySelector('td'); // Gets the first <td> (City column)
                    if (cityCell) {
                        const cityText = cityCell.textContent.toLowerCase();
                        row.style.display = cityText.includes(searchValue) ? '' : 'none';
                    }
                });
            });
        </script>
    </div>
@endsection
