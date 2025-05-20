<!DOCTYPE html>
<html>
<head>
    <title>Pusher Test</title>
    <style>
        #notification {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            z-index: 9999;
        }
    </style>
</head>
<body>

<h1>Pusher Listening...</h1>
<button onclick="sendNotification()">Send Notification</button>

<div id="notification">
</div>
<div>
    @foreach($users as $user)
        <p>{{$user->userName}}</p>
    @endforeach
</div>


<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
        cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
        encrypted: true
    });

    var channel = pusher.subscribe('test-channel');

    channel.bind('test-event', function(data) {
        showNotification(data.message);
    });

    function showNotification(message) {
        const notification = document.getElementById('notification');
        notification.innerText = message;
        notification.style.display = 'block';

        setTimeout(() => {
            notification.style.display = 'none';
        }, 4000);
    }

    function sendNotification() {
        fetch('/trigger-sucess-event');
    }
</script>
</body>
</html>
