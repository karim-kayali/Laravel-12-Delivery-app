@extends("layouts.driverExterior")

@section('stylelink')
    <link rel="stylesheet" href="{{ asset('css/AdminCSS/admin.css') }}">
    <style>
        .updateLabel {
            color: black;
            font-weight: bold;
            margin-top: 15px;
        }

        .updateInput {
            background-color: #2c2f33;
            color: #ffffff;
            border: 2px solid #6c757d;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .updateInput:disabled {
            background-color: #3a3d42;
            color: #adb5bd;
            border-color: #495057;
            cursor: not-allowed;
        }

        .updateInput:focus {
            background-color: #1f2124;
            border-color: #adb5bd;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(173, 181, 189, 0.25);
        }

        .btn-edit {
            padding: 5px 10px;
            border-radius: 8px;
            background-color: #ffc107;
            color: #000;
            text-decoration: none;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .note {
            font-size: 0.9em;
            color: #6c757d;
        }

        .distance-fields {
            display: none;
        }

        .checkbox-grid {
            display: flex;
            flex-direction: row; /* Keeps checkboxes in a row */
            flex-wrap: wrap; /* Allow wrapping to the next line if necessary */
            gap: 16px; /* Increased gap between checkboxes */
            margin-bottom: 30px; /* Increased margin below the checkboxes to create more space from the button */
        }

        .checkbox-grid label {
            color: #343a40;
            font-size: 14px;
            cursor: pointer;
            margin-right: 20px; /* Increased margin right to space out checkboxes further */
            margin-left: 5px; /* Reduce left margin to bring label closer to checkbox */
        }


        .checkbox-grid input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            border: 2px solid #6c757d;
            background-color: #fff;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            outline: none;
            box-shadow: none;
            transform: none;
        }

        .checkbox-grid input[type="checkbox"]:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        .checkbox-grid input[type="checkbox"]:disabled {
            background-color: #e0e0e0;
            border-color: #ddd;
            cursor: not-allowed;
        }

        .mother-div {
            /* Mother div styles */
            width: 100%;
            padding: 10px;
            margin-top: 20px; /* Adds spacing between sections */
        }

        .checkbox-container {
            /* Smaller div inside the mother div */
            max-width: 80%;  /* You can adjust this value based on your layout needs */
            margin: 0 auto;  /* Center the smaller div inside the mother div */
        }


    </style>
@endsection

@section('content')
    <div class="container" style="margin-bottom: 30px">
        <a class="btn btn-danger" href="{{ route('deliveries.pending') }}" style="margin-bottom: 25px">Back</a>

        <h1 class="text-black">PROFILE
            <a
                @if($onEdit)
                    hidden
                @endif
                href="{{ route('DriverTurnOnEdit', ['id' => $user->id]) }}" class="btn-edit" style="margin-left: 20px;">
                <i class="fa-solid fa-pen" style="font-size: 28px"></i>
            </a>
        </h1>

        <form method="post" action="{{ route('editDriverProfile', ['id' => $user->id]) }}">
            @csrf
            @method('put')



            <!-- Editable Fields -->
            <div class="form-group">
                <label for="userName" class="updateLabel">UserName</label>
                <input type="text" name="userName" class="form-control updateInput" id="userName"  value="{{ $user->userName }}" @if(!$onEdit) disabled @endif>
            </div>
            <!-- Uneditable Field -->
            <div class="form-group">
                <label for="email" class="updateLabel">Email</label>
                <input type="email" class="form-control updateInput" id="email" value="{{ $user->email }}" disabled>
            </div>

            <div class="form-group">
                <label class="updateLabel" for="phoneNumber">Phone Number</label>
                <input type="text" class="form-control updateInput" id="phoneNumber" name="phoneNumber" value="{{ $user->phoneNumber }}" @if(!$onEdit) disabled @endif>
            </div>

            <div class="form-group">
                <label class="updateLabel" for="vehicleType">Vehicle Type</label>
                <select class="form-control updateInput" name="vehicleType" id="vehicleType" @if(!$onEdit) disabled @endif>
                    @foreach(['Car', 'Motorcycle', 'Minivan', 'Truck'] as $type)
                        <option value="{{ $type }}" @if($user->vehicleType === $type) selected @endif>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="updateLabel" for="vehicleModel">Vehicle Model</label>
                <input type="text" class="form-control updateInput" name="vehicleModel" id="vehicleModel" value="{{ $user->vehicleModel }}" @if(!$onEdit) disabled @endif>
            </div>

            <div class="form-group">
                <label class="updateLabel" for="plateNumber">Plate Number</label>
                <input type="text" class="form-control updateInput" name="plateNumber" id="plateNumber" value="{{ $user->plateNumber }}" @if(!$onEdit) disabled @endif>
            </div>

            <div class="form-group">
                <label class="updateLabel" for="startShift">Start Shift</label>
                <input type="time" class="form-control updateInput" name="startShift" id="startShift" value="{{ $user->startShift }}" @if(!$onEdit) disabled @endif>
            </div>

            <div class="form-group">
                <label class="updateLabel" for="endShift">End Shift</label>
                <input type="time" class="form-control updateInput" name="endShift" id="endShift" value="{{ $user->endShift }}" @if(!$onEdit) disabled @endif>
            </div>

            <!-- Pricing -->
            <div class="form-group">
                <label class="updateLabel" for="weightQuantity">Weight Quantity (e.g., every X kg)</label>
                <input type="number" class="form-control updateInput" name="weightQuantity" id="weightQuantity" value="{{ $priceStructure->weightQuantity ?? old('weightQuantity') }}" @if(!$onEdit) disabled @endif>
            </div>

            <div class="form-group">
                <label class="updateLabel" for="weightPrice">Weight Price ($)</label>
                <input type="number" class="form-control updateInput" name="weightPrice" id="weightPrice" value="{{ $priceStructure->weightPrice ?? old('weightPrice') }}" @if(!$onEdit) disabled @endif>
            </div>

            <div class="form-group">
                <label class="updateLabel" for="pricing_model">Choose Distance Pricing Model</label>
                <select class="form-control updateInput" name="pricing_model" id="pricing_model" @if(!$onEdit) disabled @endif>
                    <option value="fixed" {{ old('pricing_model', $priceStructure->pricing_model) === 'fixed' ? 'selected' : '' }}>Fixed Rate</option>
                    <option value="per_km" {{ old('pricing_model', $priceStructure->pricing_model) === 'per_km' ? 'selected' : '' }}>Rate per KM</option>
                </select>
            </div>

            <!-- Fixed Rate -->
            <div class="form-group" id="fixedDistancePriceField" @if($priceStructure->pricing_model !== 'fixed') style="display:none;" @endif>
                <label class="updateLabel" for="fixedDistancePrice">Fixed Distance Price ($)</label>
                <input type="number" class="form-control updateInput" name="fixedDistancePrice" id="fixedDistancePrice" value="{{ $priceStructure->fixedDistancePrice ?? old('fixedDistancePrice') }}" @if(!$onEdit) disabled @endif>
                <div class="note">Charged regardless of distance.</div>
            </div>

            <!-- Per KM -->
            <div class="distance-fields" id="perKmFields" @if($priceStructure->pricing_model !== 'per_km') style="display:none;" @endif>
                <div class="form-group">
                    <label class="updateLabel" for="distancePerKm">Distance Per KM (e.g., every X km)</label>
                    <input type="number" class="form-control updateInput" name="distancePerKm" id="distancePerKm" value="{{ $priceStructure->distancePerKm ?? old('distancePerKm') }}" @if(!$onEdit) disabled @endif>
                </div>

                <div class="form-group">
                    <label class="updateLabel" for="distancePrice">Price For That Distance ($)</label>
                    <input type="number" class="form-control updateInput" name="distancePrice" id="distancePrice" value="{{ $priceStructure->distancePrice ?? old('distancePrice') }}" @if(!$onEdit) disabled @endif>
                </div>
            </div>

            <!-- Role -->
            <div class="form-group">
                <label class="updateLabel" for="role">Role</label>
                <input type="text" class="form-control updateInput" id="role" value="{{ $user->roles->roleName ?? 'N/A' }}" disabled>
            </div>

            <div class="form-group">
                <label class="updateLabel">Available Cities</label>

                <!-- Mother div wrapping everything -->
                <div class="mother-div">
                    <!-- Smaller div inside the mother div -->
                    <div class="checkbox-container">
                        <div class="checkbox-grid">
                            @foreach($cities as $city)
                                <label>
                                    <input type="checkbox" name="cities[]" value="{{ $city->id }}"
                                           @if(!$onEdit) disabled @endif
                                           @if($user->cities->contains($city->id)) checked @endif>
                                    {{ $city->cityName }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>



        @if($onEdit)
                <button type="submit" class="btn btn-success" style="margin-right: 10px">Update</button>

                <a class="btn btn-warning" href="{{route('displayDriverProfile', ["id" => $user->id])}}">Cancel</a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pricingModel = document.getElementById('pricing_model');
            const fixedDistancePriceField = document.getElementById('fixedDistancePriceField');
            const perKmFields = document.getElementById('perKmFields');

            function togglePricingSections() {
                const value = pricingModel.value;
                fixedDistancePriceField.style.display = value === 'fixed' ? 'block' : 'none';
                perKmFields.style.display = value === 'per_km' ? 'block' : 'none';
            }

            togglePricingSections();
            pricingModel.addEventListener('change', togglePricingSections);
        });
    </script>
@endsection
