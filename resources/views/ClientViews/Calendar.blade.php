@php
    use Illuminate\Support\Facades\Auth;$layout = Auth::user()->role_id == 1 ? 'layouts.userExterior2' : 'layouts.DriverExterior';
@endphp

@extends($layout)

@section('stylelink')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            /*padding-top: 30px;*/
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        #calendar {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .chat-btn-container {
            text-align: center;
            margin-top: 8px;
        }

        .start-chat-btn {
            padding: 6px 14px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .start-chat-btn:hover {
            background-color: #0a58ca;
        }

        .fc-event-time,
        .fc-event-username {
            font-size: 12px;
            color: #333;
            text-align: center;
        }

        .fc-event-title {
            display: none !important;
        }

        .fc-event {
            display: flex !important;
            align-items: center;
            justify-content: center;
            height: 100% !important;
            text-align: center;
            flex-direction: column;
            border: 2px solid #0d6efd !important;
            border-radius: 6px;
            background-color: #e9f5ff !important;
        }

        .fc-daygrid-event {
            margin-bottom: 6px !important;
        }
    </style>

    <div class="container" style="margin-top: 20px">
        <h2>📅 Scheduled Deliveries</h2>
        <div id="calendar"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const userRoleId = {{ Auth::user()->role_id }};

            // Request browser notification permission
            if (Notification.permission !== "granted") {
                Notification.requestPermission();
            }

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: 'short'
                },
                eventContent: function (arg) {
                    const event = arg.event;

                    const wrapper = document.createElement('div');
                    wrapper.style.display = 'flex';
                    wrapper.style.flexDirection = 'column';
                    wrapper.style.alignItems = 'center';

                    const timeEl = document.createElement('div');
                    timeEl.classList.add('fc-event-time');
                    timeEl.innerText = arg.timeText;

                    const usernameEl = document.createElement('div');
                    usernameEl.classList.add('fc-event-username');
                    if (userRoleId === 1) {
                        usernameEl.innerText = "Delivered by " + event.extendedProps.deliveredByName;
                    } else if (userRoleId === 2) {
                        usernameEl.innerText = "Delivered To " + event.extendedProps.deliveredToName;
                    }

                    wrapper.appendChild(timeEl);
                    wrapper.appendChild(usernameEl);

                    return {domNodes: [wrapper]};
                },
                eventClick: function (info) {
                    const eventDateTime = new Date(info.event.start);
                    const now = new Date();
                    const deliveryid = info.event.id;
                    const deliveredBy = info.event.extendedProps.deliveredBy;
                    const deliveredTo = info.event.extendedProps.deliveredTo;

                    let chatUserId = null;
                    if (userRoleId === 1) {
                        chatUserId = deliveredBy;
                    } else if (userRoleId === 2) {
                        chatUserId = deliveredTo;
                    }

                    // Remove existing chat buttons
                    document.querySelectorAll('.chat-btn-container').forEach(el => el.remove());

                    if (now >= eventDateTime && chatUserId) {
                        const eventElement = info.el;
                        const eventWrapper = eventElement.querySelector('div');

                        const chatBtnContainer = document.createElement('div');
                        chatBtnContainer.classList.add('chat-btn-container');

                        const chatBtn = document.createElement('button');
                        chatBtn.classList.add('start-chat-btn');
                        chatBtn.innerText = 'Start Chat';
                        chatBtn.onclick = function () {
                            window.open(`/chatify/${chatUserId}/${deliveryid}`, '_blank');
                        };

                        chatBtnContainer.appendChild(chatBtn);
                        eventWrapper.appendChild(chatBtnContainer);
                    } else {
                        alert('This delivery is not yet scheduled.');
                    }
                },
                events: function (fetchInfo, successCallback, failureCallback) {
                    fetch('/fetch-deliveries')
                        .then(response => response.json())
                        .then(events => {
                            // Trigger notification for today's deliveries
                            notifyTodaysDeliveries(events);
                            successCallback(events);
                        })
                        .catch(error => {
                            console.error('Error fetching deliveries:', error);
                            if (failureCallback) failureCallback(error);
                        });
                }
            });

            calendar.render();

            function notifyTodaysDeliveries(events) {
                const today = new Date().toLocaleDateString('en-CA'); // gives YYYY-MM-DD


                events.forEach(event => {
                    if (event.scheduledDate === today) {
                        showBrowserNotification("🚚 Delivery Today", `You have Delivery #${event.id} scheduled today.`);
                        localStorage.setItem('notified_' + event.id, 'true');
                    }
                });
            }

            function showBrowserNotification(title, message) {
                if (Notification.permission === "granted") {
                    new Notification(title, {body: message});
                }
            }
        });
    </script>

@endsection
