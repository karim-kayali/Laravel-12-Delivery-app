<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Registration - Step 1</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Custom background gradient for the body */
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

        /* Custom button style */
        .btn-custom {
            background-color: #304364;
            color: white;
            border-radius: 30px;
            padding: 12px 30px;
            font-size: 1.2em;
            border: none;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: rgb(35, 47, 67);
            color: white;
        }

        /* Link style */
        a {
            color: #304364;
            text-decoration: none;
            font-size: 1.1em;
        }

        a:hover {
            text-decoration: underline;
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

        <form method="POST" action="{{ route('driverRegisterStep1') }}">
            @csrf

            <!-- Username Input -->
            <div class="mb-3">
                <label for="userName" class="form-label">Username</label>
                <input type="text" name="userName" value="{{ old('userName') }}" class="form-control" required>
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>

            <!-- Phone Number Input -->
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="text" name="phoneNumber" value="{{ old('phoneNumber') }}" class="form-control" required>
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <!-- Password Confirmation Input -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <!-- Next Button -->
            <button type="submit" class="btn btn-custom">Next</button>
        </form>

        <!-- Register Link -->
        <div class="mt-3 text-center">
            <a href="{{ route('login') }}">Already have an account? Login</a>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
