@extends("layouts.adminExterior")
@section('stylelink')
    <link rel="stylesheet" href="{{asset("css/AdminCSS/admin.css")}}">
@endsection
@section('content')
    <div class="container" style="margin-bottom: 30px">
        <a class="btn btn-danger" href="{{route("indexAdmin")}}" style="margin-bottom: 25px">Back</a>
        <h1>PROFILE

            <a
                @if($onEdit)
                    hidden
                @endif
                href="{{route('turnOnEdit', ["id" =>$user->id])}}" style="margin-left: 20px;padding: 5px; border-radius: 5px; background-color: yellow;"><i class="fa-solid fa-pen" style="font-size: 40px"></i></a>
        </h1>

        <form method="post" action="{{route('editAdminProfile', ['id' => $user->id])}}">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="userName" class="updateLabel">UserName</label>
                <input type="text" class="form-control updateInput bg-transparent text-white border border-white rounded-full px-4 py-2 " id="userName" name="userName" value="{{$user->userName}}"
                       @if($onEdit == false)
                           disabled
                       style="cursor: not-allowed"
                       @endif
                       style="cursor: default">
            </div>
            <div class="form-group">
                <label for="email" class="updateLabel">Email</label>
                <input type="email" class="form-control updateInput bg-transparent text-white border border-white rounded-full px-4 py-2" id="email" name="email" value="{{$user->email}}"
                        disabled
                       style="cursor: not-allowed">

            </div>
            <div class="form-group">
                <label for="phoneNumber" class="updateLabel">Phone Number</label>
                <input type="text" class="form-control updateInput bg-transparent text-white border border-white rounded-full px-4 py-2" id="phoneNumber" name="phoneNumber" value="{{$user->phoneNumber}}"
                       @if($onEdit == false)
                           disabled
                       style="cursor: not-allowed"
                       @endif
                       style="cursor: default">
            </div>
            <div class="form-group">
                <label for="userName" class="updateLabel">Role </label>
                <input type="text" class="form-control updateInput bg-transparent text-white border border-white rounded-full px-4 py-2" id="phoneNumber" name="phoneNumber" value="{{$user->roles->roleName}}" disabled style="cursor: not-allowed">

            </div>

            @if($onEdit)
            <button type="submit" class="btn btn-success" style="margin-right: 10px">Update</button>

                <a class="btn btn-warning" href="{{route('displayAdminProfile', ["id" => $user->id])}}">Cancel</a>
            @endif
        </form>
        @if ($errors->any())
            <div class="alert alert-danger" style="margin: 15px">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


    </div>
@endsection
