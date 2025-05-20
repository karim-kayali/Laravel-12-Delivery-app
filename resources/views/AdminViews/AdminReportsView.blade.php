@extends('layouts.adminExterior')
@section('stylelink')
    <link rel="stylesheet" href="{{asset("css/AdminCSS/admin.css")}}">
@endsection

@section('content')
    <div class="container">
        @isset($users)
            <div style="display: block">
                <button class="btn btn-success" onclick="exportTableToExcel('reportTable', 'Users_Report')" style="margin-right: 5px">Export to Excel</button>
                <button class="btn btn-outline-danger" onclick="exportTableToPDF()" >Export to PDF</button>
            </div>

        @endisset

        <h1>Manage Reports</h1>

        <select name="roleName" id="roleName" style="color: black; margin-bottom: 20px; border-radius: 5px; padding: 2px" >
            <option disabled selected>Choose Role</option>

            <option value="user" >Users</option>
            <option value="driver">Drivers</option>
        </select>

        <script>
            document.getElementById('roleName').addEventListener('change', function () {
                const status = this.value;
                window.location.href = `/AdminReportsViewDrop/${status}`;
            });
        </script>

        @isset($message)
            <p>{{$message}}</p>
        @endisset

        @isset($status)
            <h2 style="color: white">{{ucfirst($status)}}s</h2>
        @endisset
        @isset($users)
            <table class="table" style="color: white; text-align: center" id="reportTable">
                <thead>
                <tr>
                    <th scope="col">UserName</th>
                    @if($status == "user")
                        <th scope="col">Points</th>
                    @endif

                    <th scope="col">Total Completed Orders</th>
                    @if($status == "driver")
                    <th scope="col">Total Delivery Earnings</th>
                    @else
                        <th scope="col">Total Delivery Costs</th>
                    @endisset
                    @if($status == "driver")
                    <th scope="col">Average Rating</th>
                    @endif

                </tr>
                </thead>
                <tbody>

                @foreach($users as $user)

                    <tr onclick="window.location=
                    @if($status == "user")
                    '{{ route('userDetailedReport', ['id' =>$user->id]) }}'
                    @elseif($status == "driver")
                    '{{ route('driverDetailedReport', ['id' =>$user->id]) }}'
                    @endif
                    "
                     style="cursor: pointer;">
                        <th scope="row">{{$user->userName}}</th>
                        @if($status == "user")
                            <td>{{$user->points}}</td>
                        @endif

                        <td>
                            @if($status == "user")
                                {{$user->deliveriesReceived->count()}}
                            @elseif($status == "driver")
                                {{$user->deliveriesMade->count()}}
                            @endif
                        <td>
                            @if($status == "user")
                            {{round($user->getTotalDeliveryPriceAttribute(),2)}}$
                            @elseif($status == "driver")
                                {{round($user->getTotalDeliveryPriceAttributeDriver(),2)}}$
                            @endif
                        </td>
                        @if($status == "driver")
                            <td>{{round($user->avgReviews(),2)}}</td>
                        @endif

                    </tr>

                @endforeach

                </tbody>

            </table>
            @isset($emptyMessage)
                <p>{{$emptyMessage}}</p>
            @endisset
        @endisset
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

            doc.save('Users_Report.pdf');
        }
    </script>

@endsection
