<!DOCTYPE html>
<html>
<head>
    <title>Page 2</title>
</head>
<body>
    <h1>ข้อมูลจาก Page 1</h1>
    <table id="dataTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="id"></td>
                <td id="name"></td>
                <td id="age"></td>
            </tr>
        </tbody>
    </table>

    <script>
        var socket = new WebSocket("ws://localhost:8080");

        socket.onmessage = function(event) {
            console.log(event)
            var receivedData = JSON.parse(event.data);
            console.log("รับข้อมูล: ", receivedData);

            document.getElementById("id").textContent = receivedData.id;
            document.getElementById("name").textContent = receivedData.name;
            document.getElementById("age").textContent = receivedData.age;
        };
    </script>
</body>
</html>
