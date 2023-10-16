<!DOCTYPE html>
<html>
<head>
    <title>Page 1</title>
</head>
<body>
    <button id="sendButton">ส่งข้อมูลไปยัง Page 2</button>

    <script>
        var socket = new WebSocket("ws://localhost:8080");

        document.getElementById("sendButton").addEventListener("click", function () {
            var data = {
                id: 1,
                name: "John",
                age: 30
            };
            var message = JSON.stringify(data);
            socket.send(message);
        });
    </script>
</body>
</html>
