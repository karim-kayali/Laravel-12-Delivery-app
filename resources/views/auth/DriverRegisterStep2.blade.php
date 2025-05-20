<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Registration - Step 2</title>

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
            max-width: 600px;
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

        /* Form labels */
        .form-label {
            color: #304364;
            font-weight: bold;
        }

        /* Form controls */
        .form-control {
            border-radius: 8px;
            padding: 15px;
            font-size: 1em;
        }

        .error {
            color: red;
            font-size: 1em;
            margin-bottom: 20px;
            text-align: center;
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Please Enter Your Vehicle Details</h1>

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

        <!-- Form for driver registration step 2 -->
        <form method="POST" action="{{ route('driverRegisterStep2') }}">
            @csrf

            <!-- Vehicle Type -->
            <div class="mb-3">
                <label for="vehicleType" class="form-label">Vehicle Type</label>
                <select name="vehicleType" class="form-control" required>
                    <option value="Car" {{ old('vehicleType') == 'Car' ? 'selected' : '' }}>Car</option>
                    <option value="Motorcycle" {{ old('vehicleType') == 'Motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                    <option value="Minivan" {{ old('vehicleType') == 'Minivan' ? 'selected' : '' }}>Minivan</option>
                    <option value="Truck" {{ old('vehicleType') == 'Truck' ? 'selected' : '' }}>Truck</option>
                </select>
            </div>

            <!-- Vehicle Model -->
            <div class="mb-3">
                <label for="vehicleModel" class="form-label">Vehicle Model</label>
                <input type="text" name="vehicleModel" value="{{ old('vehicleModel') }}" class="form-control" required>
            </div>

            <!-- Plate Number -->
            <div class="mb-3">
                <label for="plateNumber" class="form-label">Plate Number</label>
                <input type="text" name="plateNumber" value="{{ old('plateNumber') }}" class="form-control" required>
            </div>

            <!-- Start Shift -->
            <div class="mb-3">
                <label for="startShift" class="form-label">Start Hour</label>
                <input type="time" name="startShift" value="{{ old('startShift') }}" class="form-control" required>
            </div>

            <!-- End Shift -->
            <div class="mb-3">
                <label for="endShift" class="form-label">End Hour</label>
                <input type="time" name="endShift" value="{{ old('endShift') }}" class="form-control" required>
            </div>

           <!-- Cities to Serve -->
           <div class="mb-3">
    <label class="form-label">Cities to Serve</label>
    <div class="form-check">
        @foreach ($cities as $city)
            <div class="form-check mb-1">
                <input class="form-check-input" type="checkbox" 
                       name="citiesToServe[]" 
                       value="{{ $city->id }}" 
                       id="city-{{ $city->id }}"
                       {{ in_array($city->id, old('citiesToServe', [])) ? 'checked' : '' }}>
                <label class="form-check-label" for="city-{{ $city->id }}">
                    {{ $city->cityName }}
                </label>
            </div>
        @endforeach
    </div>
</div>


<!-- Weight Quantity -->
<div class="mb-3">
    <label for="weightQuantity" class="form-label">Weight Quantity (kg)</label>
    <input type="number" name="weightQuantity" value="{{ old('weightQuantity') }}" class="form-control" required>
</div>

<!-- Weight Price -->
<div class="mb-3">
    <label for="weightPrice" class="form-label">Weight Price per kg ($)</label>
    <input type="number" name="weightPrice" value="{{ old('weightPrice') }}" class="form-control" required>
</div>

<!-- Pricing Model Selection -->
<div class="mb-3">
    <label for="priceModel" class="form-label">Pricing Model</label>
    
    <select name="priceModel" class="form-control" 
        onchange="document.getElementById('finalSubmit').value = ''; this.form.submit();" required>
        <option value="">-- Select --</option>
        <option value="fixed" {{ old('priceModel') == 'fixed' ? 'selected' : '' }}>Fixed</option>
        <option value="dynamic" {{ old('priceModel') == 'dynamic' ? 'selected' : '' }}>Dynamic</option>
    </select>
</div>

<!-- Hidden field to control when the form is "finally" submitted -->
<input type="hidden" name="finalSubmit" id="finalSubmit" value="1">

<!-- Fixed Price Input -->
@if(old('priceModel') == 'fixed')
    <div class="mb-3">
        <label for="fixedPrice" class="form-label">Fixed Price</label>
        <input type="number" name="fixedPrice" value="{{ old('fixedPrice') }}" class="form-control" required>
    </div>
@endif

<!-- Dynamic Pricing Inputs -->
@if(old('priceModel') == 'dynamic')
    <div class="mb-3">
        <label for="distance" class="form-label">Distance (km)</label>
        <input type="number" name="distance" value="{{ old('distance') }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="pricePerKm" class="form-label">Price per km</label>
        <input type="number" name="pricePerKm" value="{{ old('pricePerKm') }}" class="form-control" required>
    </div>
@endif



            <!-- Submit Button -->
            <button type="submit" class="btn btn-custom">Finish Registration</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
