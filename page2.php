<!DOCTYPE html>
<html>
<head>
    <title>Page 2</title>
</head>
<body>
    <div id="messageDisplay">ข้อความ</div>

    <script>
        var socket = new WebSocket("ws://localhost:8080"); // เชื่อมต่อไปยังเซิร์ฟเวอร์ WebSocket

        // รับข้อมูลที่มาจากเซิร์ฟเวอร์ WebSocket
        socket.onmessage = function(event) {
            console.log(event)
            var receivedMessage = event.data;
            console.log("รับข้อมูล: " + receivedMessage);
            document.getElementById("messageDisplay").textContent = receivedMessage;
        };
    </script>
</body>
</html>
