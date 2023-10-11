<!DOCTYPE html>
<html>
<head>
    <title>WebSocket Example</title>
</head>
<body>
    <h1>WebSocket Example</h1>

</body>
<script>
        // var conn = new WebSocket('ws://127.0.0.1/:8080');
        // var conn = new WebSocket('ws://https://64cb-180-183-108-126.ngrok-free.app/:8080');

        // https://64cb-180-183-108-126.ngrok-free.app/
        

        conn.onopen = function(e) {
            console.log("Connection established!");
            conn.send('Hello World!');
        };

        conn.onmessage = function(e) {
            console.log(e.data);
        };
    </script>
</html>
