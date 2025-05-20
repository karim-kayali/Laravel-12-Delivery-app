@extends('layouts.UserExterior2')

@section('content')
    <script>
        window.onload = function() {
            sendNotification()
        };

    </script>

    <style>
        .transaction-page {
            margin-top: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .checkmark {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .card h1 {
            margin: 0 0 10px;
            color: #333;
        }

        .card p {
            color: #666;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="transaction-page" style="margin-top: 20px; margin-bottom: 20px">
        <div class="card">
            <div class="checkmark">✔️</div>
            <h1>Transaction Complete</h1>
            <p>Your payment has been processed successfully.</p>
            <a href="{{ route('PendingDeliveries') }}" class="btn btn-success">Go to Pending Deliveries</a>
        </div>
    </div>
@endsection
