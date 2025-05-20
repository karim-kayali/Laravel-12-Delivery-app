<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #00358d, #304364, #00112e);
            height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        .card {
            max-width: 420px;
            width: 100%;
            margin-top: 100px;
        }
        .btn-primary {
            background-color: #00358d;
            border-color: #00358d;
        }
        .btn-primary:hover {
            background-color: #00112e;
        }
        .resend {
            font-size: 0.9em;
            margin-top: 10px;
            display: block;
            text-align: center;
            color: #00112e;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

    <div class="card shadow p-4 bg-white">
        <h4 class="text-center mb-4">Email Verification</h4>

        {{-- Session error (e.g., expired or incorrect OTP) --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('verifyOtp') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') ?? old('email') }}">

            <div class="mb-3">
                <label for="otp_code" class="form-label">Enter the 6-digit OTP sent to your email</label>
                <input type="text" name="otp_code" class="form-control" maxlength="6" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Verify</button>
        </form>

        {{-- Uncomment once resendOtp route/controller is ready --}}
        <form action="{{ route('resendOtp') }}" method="POST" class="mt-2 text-center">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') ?? old('email') }}">
            <button class="btn btn-link resend" type="submit">Didn't get it? Resend OTP</button>
        </form>
    </div>

</body>
</html>
