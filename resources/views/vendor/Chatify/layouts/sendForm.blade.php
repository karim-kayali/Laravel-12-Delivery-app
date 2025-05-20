<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data">
        @csrf
        <label><span class="fas fa-plus-circle"></span><input disabled='disabled' type="file" class="upload-attachment" name="file" accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}}, .{{implode(', .',config('chatify.attachments.allowed_files'))}}" /></label>
        <button class="emoji-button"><span class="fas fa-smile"></span></button>
        <textarea readonly='readonly' name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>
        <button disabled='disabled' class="send-button"><span class="fas fa-paper-plane"></span></button>
    </form>

    @if((Auth::user()->role_id == 2 &&Auth::user()->gotRegistered=='accepted')|| Auth::user()->role_id == 1)
    <div style="display: flex; align-items: center;">
        <!-- Track Delivery Button (untouched) -->
        <form method="GET" action="{{route('getMaps', ["id" => $deliveryid])}}" target="_blank">
            @csrf
            <button class="btn a-btn-success" style="margin: 10px; color: white; padding: 10px">Track Delivery</button>
        </form>
        @endif
        <!-- For admin (role_id == 2) -->
        @if(Auth::user()->role_id == 2 &&Auth::user()->gotRegistered=='accepted')
            <form id="status-form" style="margin-left: 5px;">
                @csrf
                <select name="status" id="status-select" style="padding: 8px; border-radius: 4px;">
                    <option value="in_progress" selected>In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </form>

            <script>
                document.getElementById('status-select').addEventListener('change', function () {
                    if (this.value === 'completed') {
                        const form = document.getElementById('status-form');
                        const formData = new FormData(form);

                        fetch("{{ route('ChangeStatusToComplete', ['id' => $deliveryid]) }}", {
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: formData
                        }).then(() => {
                            alert("Delivery completed. This tab will now close.");
                            window.close();
                        }).catch(() => {
                            alert("Something went wrong.");
                        });
                    }
                });
            </script>


        @elseif(Auth::user()->role_id == 1)

            <button id="order-received-btn" class="btn" style="margin-left: 10px; padding: 10px; color: black; background-color: white; border: 2px solid black; border-radius: 5px;">
                Order Received
            </button>


            <script>
                document.getElementById('order-received-btn').addEventListener('click', function () {
                    fetch("{{ route('getDeliveryStatus', ['id' => $deliveryid]) }}")
                        .then(response => response.json())
                        .then(data => {
                            if (data.deliveryStatus === 'completed') {
                                alert("Thank you! Closing tab.");
                                window.close();
                            } else {
                                alert("Order has not arrived yet.");
                            }
                        })
                        .catch(() => {
                            alert("Could not check delivery status.");
                        });
                });
            </script>



        @endif

    </div>
</div>
