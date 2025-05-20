@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.UserExterior2')

@section('content')

    <head>
        <script src="https://js.stripe.com/v3/"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <div class="container mt-4">
        <h2>PAYMENT PAGE</h2>

        <div class="mb-4">
            <h5>Delivery Information</h5>

            <div class="alert alert-info">
                <strong>Total Weight Price:</strong> ${{ number_format($totalWeightPrice, 2) }}<br>
                <strong>Total Distance Price:</strong> ${{ number_format($totalDistancePrice, 2) }}<br>
                <strong>Total Delivery Price (USD):</strong> $<span id="usd-price">{{ number_format($totalDeliveryPrice, 2) }}</span><br>
                <strong id="finalPriceContainer" style="display:none;">Discounted Price:</strong>
                <span id="discountedPrice" class="text-success"></span>
            </div>

            <form method="POST" id="paymentForm">
                @csrf

                <input type="hidden" name="driver_id" value="{{ $driverId }}">
                @foreach($deliveryData as $key => $value)
                    <input type="hidden" name="deliveryData[{{ $key }}]" value="{{ $value }}">
                @endforeach

                <input type="hidden" name="totalDeliveryPrice" value="{{ $totalDeliveryPrice }}">
                <input type="hidden" name="paymentMethod" id="finalPaymentMethod" value="Credit Card">

                @php
                    $userPoints = Auth::user()->points;
                    $discounts = [];

                    if ($userPoints >= 150) $discounts[15] = '15% (150 points)';
                    if ($userPoints >= 250) $discounts[20] = '20% (250 points)';
                    if ($userPoints >= 400) $discounts[30] = '30% (400 points)';
                @endphp

                <div class="form-group mb-3">
                    <label for="discountSelect"><strong>Choose Discount</strong></label>
                    <select class="form-control" id="discountSelect" name="discountPercentage" style="color: black; border-radius: 5px">
                        <option value="0">No Discount</option>
                        @if ($userPoints >= 150)
                            <option value="15">15% (150 points)</option>
                        @endif
                        @if ($userPoints >= 250)
                            <option value="20">20% (250 points)</option>
                        @endif
                        @if ($userPoints >= 400)
                            <option value="30">30% (400 points)</option>
                        @endif
                    </select>
                </div>


                <div class="form-group mb-3">
                    <label><strong>Select Payment Method</strong></label><br>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethodType" value="stripe" id="payStripe" checked>
                        <label class="form-check-label" for="payStripe">Pay with Credit Card</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethodType" value="cash" id="payCash">
                        <label class="form-check-label" for="payCash">Cash on Delivery</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethodType" value="crypto" id="payCrypto">
                        <label class="form-check-label" for="payCrypto">Pay with Crypto</label>
                    </div>
                </div>

                <div id="currencySection" class="mb-3" style="display: none;">
                    <label for="currencySelect"><strong>Select Currency:</strong></label>
                    <select class="form-control" id="currencySelect" style="color: black; border-radius: 5px">
                        <option value="USD">US dollars (USD)</option>
                        <option value="EUR">Euros (EUR)</option>
                        <option value="GBP">British Pounds (GBP)</option>
                        <option value="LBP">Lebanese Lira (LBP)</option>
                        <option value="CAD">Canadian Dollar (CAD)</option>
                    </select>
                    <p class="mt-2 text-success">
                        Equivalent Amount: <span id="convertedAmount">--</span>
                    </p>
                </div>

                <button type="submit" class="btn btn-success">Confirm Payment</button>
            </form>
        </div>
    </div>

    <script>
    //    const stripe = Stripe("pk-Key");
        const form = document.getElementById('paymentForm');
        const usdPrice = parseFloat(document.getElementById('usd-price').innerText);

        function getSelectedDiscountedPrice() {
            const discountSelect = document.getElementById('discountSelect');
            const selectedDiscount = parseFloat(discountSelect?.value || 0);
            return selectedDiscount > 0 ? usdPrice - (usdPrice * selectedDiscount / 100) : usdPrice;
        }

        function updateDiscountDisplay() {
            const discountSelect = document.getElementById('discountSelect');
            const selectedDiscount = parseFloat(discountSelect?.value || 0);
            const discountedPrice = getSelectedDiscountedPrice();

            if (selectedDiscount > 0) {
                document.getElementById('discountedPrice').innerText = "$" + discountedPrice.toFixed(2);
                document.getElementById('finalPriceContainer').style.display = "inline";
            } else {
                document.getElementById('discountedPrice').innerText = "";
                document.getElementById('finalPriceContainer').style.display = "none";
            }

            const isCash = document.getElementById('payCash').checked;
            if (isCash) convertCurrency(document.getElementById('currencySelect').value);
        }

        function updatePaymentMethodValue() {
            const selected = document.querySelector('input[name="paymentMethodType"]:checked').value;
            const paymentMethodInput = document.getElementById('finalPaymentMethod');
            if (selected === 'cash') {
                const currency = document.getElementById('currencySelect').value;
                paymentMethodInput.value = `Cash (${currency})`;
            } else if (selected === 'stripe') {
                paymentMethodInput.value = 'Credit Card';
            } else {
                paymentMethodInput.value = 'Crypto';
            }
        }

        function convertCurrency(toCurrency) {
            const finalPrice = getSelectedDiscountedPrice();
            fetch('https://api.exchangerate-api.com/v4/latest/USD')
                .then(res => res.json())
                .then(data => {
                    const rate = data.rates[toCurrency];
                    const converted = (finalPrice * rate).toFixed(2);
                    document.getElementById('convertedAmount').innerText = `${converted} ${toCurrency}`;
                }).catch(() => {
                document.getElementById('convertedAmount').innerText = 'Error loading rate';
            });
        }

        document.getElementById('discountSelect')?.addEventListener('change', updateDiscountDisplay);

        document.getElementById('currencySelect').addEventListener('change', function () {
            convertCurrency(this.value);
            updatePaymentMethodValue();
        });

        ['payCash', 'payStripe', 'payCrypto'].forEach(id => {
            document.getElementById(id).addEventListener('change', () => {
                const isCash = id === 'payCash';
                document.getElementById('currencySection').style.display = isCash ? 'block' : 'none';
                if (isCash) convertCurrency(document.getElementById('currencySelect').value);
                updatePaymentMethodValue();
            });
        });

        form.addEventListener('submit', async function (e) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const selected = document.querySelector('input[name="paymentMethodType"]:checked').value;
            const discountPercent = parseFloat(document.getElementById('discountSelect')?.value || 0);
            const finalPrice = getSelectedDiscountedPrice();
            const deliveryData = Object.fromEntries(
                Array.from(document.querySelectorAll('input[name^="deliveryData"]')).map(input => {
                    const keyMatch = input.name.match(/^deliveryData\[(.+)\]$/);
                    return keyMatch ? [keyMatch[1], input.value] : [];
                })
            );

            if (selected === 'stripe') {
                e.preventDefault();
                const response = await fetch("{{ route('stripe.session') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                    body: JSON.stringify({
                        totalDeliveryPrice: finalPrice,
                        totalWeightPrice: {{ $totalWeightPrice }},
                        totalDistancePrice: {{ $totalDistancePrice }},
                        driverId: {{ $driverId }},
                        paymentMethod: 'Credit Card',
                        deliveryData: deliveryData,
                        discount: discountPercent
                    })
                });
                const data = await response.json();
                if (data?.id) stripe.redirectToCheckout({ sessionId: data.id });
            } else if (selected === 'cash') {
                e.preventDefault();
                const currency = document.getElementById('currencySelect').value;
                const queryString = new URLSearchParams({
                    driverId: '{{ $driverId }}',
                    totalPrice: finalPrice,
                    totalWeightPrice: '{{ $totalWeightPrice }}',
                    totalDistancePrice: '{{ $totalDistancePrice }}',
                    paymentMethod: `Cash (${currency})`,
                    deliveryData: JSON.stringify(deliveryData),
                    discount: discountPercent
                }).toString();

                window.location.href = `{{ route('Success') }}?${queryString}`;
            } else if (selected === 'crypto') {
                e.preventDefault();
                const response = await fetch("{{ route('coinbase.session') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                    body: JSON.stringify({
                        totalDeliveryPrice: finalPrice,
                        driverId: {{ $driverId }},
                        paymentMethod: 'Crypto',
                        deliveryData: deliveryData,
                        discount: discountPercent
                    })
                });

                const data = await response.json();
                if (data?.hosted_url) {
                    window.location.href = data.hosted_url;
                } else {
                    alert("Unable to create crypto session.");
                }
            }
        });
    </script>
@endsection
