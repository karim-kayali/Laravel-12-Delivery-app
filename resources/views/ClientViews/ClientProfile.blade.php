@extends("layouts.userExterior2")

@section('stylelink')
    <link rel="stylesheet" href="{{asset("css/UserCSS/Profile.css")}}">
@endsection

@section('content')

<div class="container py-5 container-white-bg" style="background-color: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <!-- Title Section -->
    <div class="text-center mb-4">
        <h1>PROFILE</h1>

        <a
            @if($onEdit)
                hidden
            @endif
            href="{{route('UserturnOnEdit', ["id" =>$user->id])}}" 
            class="btn-edit">
            <i class="fa-solid fa-pen" style="font-size: 40px"></i>
        </a>
    </div>

    <!-- Profile Form -->
    <form method="post" action="{{route('editUserProfile', ['id' => $user->id])}}">
        @csrf
        @method('put')

        <!-- UserName -->
        <div class="form-group">
            <label for="userName" class="updateLabel">UserName</label>
            <input type="text" class="form-control updateInput" id="userName" name="userName" value="{{$user->userName}}"
                @if($onEdit == false)
                    disabled
                    style="cursor: not-allowed"
                @endif
                style="cursor: default">
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="updateLabel">Email</label>
            <input type="email" class="form-control updateInput" id="email" name="email" value="{{$user->email}}"
                disabled
                style="cursor: not-allowed">
        </div>

        <!-- Phone Number -->
        <div class="form-group">
            <label for="phoneNumber" class="updateLabel">Phone Number</label>
            <input type="text" class="form-control updateInput" id="phoneNumber" name="phoneNumber" value="{{$user->phoneNumber}}"
                @if($onEdit == false)
                    disabled
                    style="cursor: not-allowed"
                @endif
                style="cursor: default">
        </div>

        <!-- Role -->
        <div class="form-group">
            <label for="role" class="updateLabel">Role</label>
            <input type="text" class="form-control updateInput" id="role" name="role" value="{{$user->roles->roleName}}" disabled style="cursor: not-allowed">
        </div>

        <!-- Update Button (when in edit mode) -->
        @if($onEdit)
            <button type="submit" class="btn btn-success" style="margin-right: 10px">Update</button>
            <a class="btn btn-warning" href="{{route('displayUserProfile', ["id" => $user->id])}}">Cancel</a>
        @endif
    </form>

    <!-- Errors Section -->
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
