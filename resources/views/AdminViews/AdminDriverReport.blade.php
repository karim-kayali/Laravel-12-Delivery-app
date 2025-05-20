@extends('layouts.adminExterior')
@section('stylelink')
    <link rel="stylesheet" href="{{asset("css/AdminCSS/admin.css")}}">
@endsection
@section('content')
    <div class="container">
        <a class="btn btn-danger" href="{{route('AdminReportsView')}}">Back</a>
        @if(@isset($deliveries))
            <div style="display: block; margin-top: 10px" >
                <button class="btn btn-success" onclick="exportTableToExcel('reportTable', '{{ $deliveries->first()->deliveredToUser->userName }}_Report')" style="margin-right: 5px">Export to Excel</button>
                <button class="btn btn-outline-danger" onclick="exportTableToPDF()">Export to PDF</button>
            </div>


            <h1 style="margin-top: 10px">{{$deliveries->first()->deliveredByUser->userName}}'s Detailed Report</h1>
            <table class="table" style="color: white; text-align: center" id="reportTable">
                <thead>
                <tr>
                    <th scope="col">Weight (KG)</th>
                    <th scope="col">Total Weight Price</th>
                    <th scope="col">Total Distance Price</th>
                    <th scope="col">Total Delivery Price</th>
                    <th scope="col">Scheduled Delivery Date</th>

                    <th scope="col">Pick Up</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Delivered To</th>

                </tr>
                </thead>
                <tbody>
                @foreach($deliveries as $delivery)
                    <tr>
                        <th scope="row">{{$delivery->weightQuantity}}</th>
                        <td>{{round($delivery->totalWeightPrice,2)}}$</td>
                        <td>{{round($delivery->totalDistancePrice,2)}}$</td>
                        <td>{{round($delivery->totalDeliveryPrice,2)}}$</td>
                        <td>{{$delivery->scheduledDeliveryDate}}</td>
                        <td id="pickup-{{ $delivery->id }}">Loading...</td>
                        <td id="destination-{{ $delivery->id }}">Loading...</td>
                        <td>{{$delivery->deliveredToUser->userName}}</td>

                    </tr>
                    <script>
                        async function getCityName(lat, lon) {
                            try {
                                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`, {
                                    headers: { 'User-Agent': 'Mozilla/5.0' }
                                });
                                const data = await response.json();
                                return data.address.city || data.address.town || data.address.village || 'Unknown';
                            } catch {
                                return 'Unknown';
                            }
                        }

                        document.addEventListener("DOMContentLoaded", async function () {
                            // Replace with a loop if you have many rows
                            const pickupCity = await getCityName({{ $delivery->pickedFromX }}, {{ $delivery->pickedFromY }});
                            const destinationCity = await getCityName({{ $delivery->destinationX }}, {{ $delivery->destinationY }});

                            document.getElementById("pickup-{{ $delivery->id }}").innerText = pickupCity;
                            document.getElementById("destination-{{ $delivery->id }}").innerText = destinationCity;
                        });
                    </script>
                @endforeach

                </tbody>
            </table>
        @endif
    </div>
    <script>
        function exportTableToExcel(tableID, filename = '') {
            const table = document.getElementById(tableID);
            const wb = XLSX.utils.table_to_book(table, {sheet: "Sheet 1"});
            XLSX.writeFile(wb, filename ? filename + '.xlsx' : 'report.xlsx');
        }
    </script>
    <script>
        async function exportTableToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.autoTable({
                html: '#reportTable', // your table ID
                theme: 'grid',
                headStyles: { fillColor: [41, 128, 185] },
                margin: { top: 20 },
            });

            doc.save('{{ $deliveries->first()->deliveredToUser->userName }}_Report');
        }
    </script>
    <script>
        async function getCityName(lat, lon) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`, {
                    headers: { 'User-Agent': 'Mozilla/5.0' }
                });
                const data = await response.json();
                return data.address.city || data.address.town || data.address.village || 'Unknown';
            } catch {
                return 'Unknown';
            }
        }
    </script>



@endsection
