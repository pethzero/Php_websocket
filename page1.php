<!DOCTYPE html>
<html>
<head>
    <title>Page 1</title>
</head>
<body>
    <button id="sendButton">ส่งข้อมูลไปยัง Page 2</button>

    <script>
        var socket = new WebSocket("ws://localhost:8080"); // เชื่อมต่อไปยังเซิร์ฟเวอร์ WebSocket

        document.getElementById("sendButton").addEventListener("click", function () {
            var message = "insert";
            socket.send(message); // ส่งข้อมูลไปยังเซิร์ฟเวอร์ WebSocket
        });

        // รับข้อมูลที่มาจากเซิร์ฟเวอร์ WebSocket
        socket.onmessage = function(event) {
            var receivedMessage = event.data;
            console.log("รับข้อมูล: " + receivedMessage);
            // ทำอะไรก็ตามที่คุณต้องการกับข้อมูลที่รับมา
        };
    </script>
</body>
</html>
