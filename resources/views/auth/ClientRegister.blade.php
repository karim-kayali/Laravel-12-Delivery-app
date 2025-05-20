<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
       
body {
    background: linear-gradient(to right, rgb(18, 39, 73), #304364, #00112e);
    font-family: 'Arial', sans-serif;
}

/* Center the container and apply a shadow */
.container {
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    padding: 40px;
    max-width: 450px;
    margin-top: 100px;
}

/* Title */
h1 {
    color: #304364;
    text-align: center;
    font-size: 2.5em;
    margin-bottom: 30px;
    font-weight: 700;
}

/* Error message styling */
.error {
    color: red;
    font-size: 1em;
    margin-bottom: 20px;
    text-align: center;
}


.btn-social {
    background-color: rgb(198, 204, 215); 
    color:  #304364;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px; 
}
.btn-social:hover {
    background-color:rgb(182, 185, 192);
    color:  #304364; 
}
.btn-social img {
    width: 20px;
    height: 20px;
    margin-right: 10px;
}


.btn-register {
    background-color:  #304364; 
    color: white;
    border-radius: 30px;
    padding: 12px 30px;
    font-size: 1.2em;
    border: none;
    width: 100%;
}

.btn-register:hover {
    background-color:rgb(35, 47, 67);
    color: white; 
}


a {
    color: #304364;
    text-decoration: none;
    font-size: 1.1em;
}

a:hover {
    text-decoration: underline;
    color:rgb(35, 47, 67);
}

.form-label {
    color: #304364;
    font-weight: bold;
}

.form-control {
    border-radius: 8px;
    padding: 15px;
    font-size: 1em;
}

    </style>
</head>

<body>
    <div class="container">
        <h1>Sign Up</h1>

        <!-- Display validation errors if any -->
        @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{  route('clientRegister') }}">
            @csrf

            <div class="mb-3">
                <label for="userName" class="form-label">Username</label>
                <input type="text" name="userName" class="form-control" value="{{ old('userName') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number (optional)</label>
                <input type="text" name="phoneNumber" class="form-control" value="{{ old('phoneNumber') }}">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-register">Register</button>
            </div>
        </form>

       
        <a href="{{ route('googleLogin') }}" class="btn btn-social d-flex align-items-center justify-content-center">
    <img src="data:image/png;base64,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" alt="Google Logo" style="width: 20px; height: 20px; margin-right: 10px;">
    Register with Google
</a>

<a href="{{ route('githubLogin') }}" class="btn btn-social d-flex align-items-center justify-content-center">
                <img src="data:image/png;base64,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" alt="GitHub Logo" style="width: 20px; height: 20px; margin-right: 10px;">
    Register with GitHub
</a>


        <div class="text-center mt-3">
            <a href="{{ route('login') }}">Already have an account? Login</a>
        </div>
    
    <div class="text-center mt-3">
            <a href="{{ route('driverRegisterStep1') }}">Register as a driver?</a>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
