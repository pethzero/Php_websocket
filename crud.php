<!DOCTYPE html>
<html>

<head>
    <title>WebSocket Example</title>
</head>

<body>
    <h1>WebSocket Example</h1>

</body>
<script>
    var conn = new WebSocket('ws://localhost:8080');
    var database;

    conn.onopen = function(e) {
        console.log("Connection established!");

        var data = {
            action: 'databaseSelect',
            // ส่งข้อมูลอื่น ๆ ที่คุณต้องการในนี้
        };

        conn.send(JSON.stringify(data));
        // getDataFromServer().then(() => {
        //     // หลังจากที่ข้อมูลถูกดึงมาแล้ว
        //     conn.send(JSON.stringify(database)); // ส่งข้อมูลผ่าน WebSocket
        // });
    };

    conn.onmessage = function(e) {
        console.log(e.data);
    };



    async function getDataFromServer() {
        tableData = [];
        tableData.push({});
        try {
            const response1 = await fetch('crud/process_select.php', {
                method: 'POST',
                body: set_formdata(),
            });
            if (!response1.ok) {
                throw new Error('เกิดข้อผิดพลาดในการส่งข้อมูลเริ่มต้น');
            }
            const data1 = await response1.json();
            database = data1.datasql;
        } catch (error) {
            console.error(error);
            $('.loading').hide();
        }
    }

    function set_formdata() {
        var formData = new FormData();
        formData.append('queryIdHD', 'SELECT_HIS');
        formData.append('condition', 'NULL');
        formData.append('tableData', JSON.stringify(tableData));
        return formData;
    }
</script>

</html>