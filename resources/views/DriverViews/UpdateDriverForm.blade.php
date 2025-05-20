@extends('layouts.DriverExterior')

@section('content')
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 35px;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 26px;
            color: #333;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #007bff;
            outline: none;
        }

        .success-message {
            background-color: #e0ffe0;
            color: #2e7d32;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        .form-group button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 0;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s ease;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .note {
            font-size: 13px;
            color: #777;
            margin-top: -8px;
            margin-bottom: 8px;
        }

        .hidden {
            display: none;
        }

        .error {
            color: red;
            font-size: 12px;
        }
    </style>

    <div class="form-container">
        <h1>Update Your Shift & Pricing</h1>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('driver.update.submit', ['id' => auth()->id()]) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="startShift">Shift Start</label>
                <input type="time" name="startShift" id="startShift" value="{{ old('startShift', $user->startShift) }}">
                @error('startShift')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="endShift">Shift End</label>
                <input type="time" name="endShift" id="endShift" value="{{ old('endShift', $user->endShift) }}">
                @error('endShift')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="weightQuantity">Weight Quantity (e.g., every X kg)</label>
                <input type="number" name="weightQuantity" id="weightQuantity" value="{{ old('weightQuantity', $priceStructure->weightQuantity) }}">
                @error('weightQuantity')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="weightPrice">Weight Price ($ for that quantity)</label>
                <input type="number" name="weightPrice" id="weightPrice" step="0.01" value="{{ old('weightPrice', $priceStructure->weightPrice) }}">
                @error('weightPrice')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="pricing_model">Choose Distance Pricing Model</label>
                <select name="pricing_model" id="pricing_model">
                    <option value="fixed" {{ old('pricing_model', $priceStructure->pricing_model) == 'fixed' ? 'selected' : '' }}>Fixed Rate</option>
                    <option value="per_km" {{ old('pricing_model', $priceStructure->pricing_model) == 'per_km' ? 'selected' : '' }}>Rate per KM</option>
                </select>
                @error('pricing_model')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div id="fixed_rate_section" class="form-group {{ old('pricing_model', $priceStructure->pricing_model) == 'fixed' ? '' : 'hidden' }}">
                <label for="fixedDistancePrice">Fixed Distance Price ($)</label>
                <input type="number" name="fixedDistancePrice" id="fixedDistancePrice" step="0.01" value="{{ old('fixedDistancePrice', $priceStructure->fixedDistancePrice) }}">
                <div class="note">Charged regardless of distance.</div>
                @error('fixedDistancePrice')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div id="per_km_section" class="form-group {{ old('pricing_model', $priceStructure->pricing_model) == 'per_km' ? '' : 'hidden' }}">
                <label for="distancePerKm">Distance Per KM (e.g., every X km)</label>
                <input type="number" name="distancePerKm" id="distancePerKm" step="0.01" value="{{ old('distancePerKm', $priceStructure->distancePerKm) }}">
                @error('distancePerKm')
                <div class="error">{{ $message }}</div>
                @enderror

                <label for="distancePrice" style="margin-top:10px;">Price For That Distance ($)</label>
                <input type="number" name="distancePrice" id="distancePrice" step="0.01" value="{{ old('distancePrice', $priceStructure->distancePrice) }}">
                @error('distancePrice')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit">Save My Info</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pricingModel = document.getElementById('pricing_model');
            const fixedSection = document.getElementById('fixed_rate_section');
            const perKmSection = document.getElementById('per_km_section');

            function togglePricingSections() {
                const value = pricingModel.value;
                fixedSection.classList.add('hidden');
                perKmSection.classList.add('hidden');

                if (value === 'fixed') {
                    fixedSection.classList.remove('hidden');
                } else if (value === 'per_km') {
                    perKmSection.classList.remove('hidden');
                }
            }

            pricingModel.addEventListener('change', togglePricingSections);
            togglePricingSections(); // Initial load
        });
    </script>
@endsection
