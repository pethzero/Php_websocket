<!DOCTYPE html>
<html>

<head>
    <title>PHP WebSocket Chat</title>
    <!-- <link type="text/css" rel="stylesheet" href="style.css" /> -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

</head>

<style type="text/css">
    body {
        font: 12px arial;
        color: #222;
        text-align: center;
        padding: 35px;
    }

    #chatbox {
        text-align: left;
        margin: 0 auto;
        margin-bottom: 25px;
        padding: 10px;
        background: #fff;
        height: 270px;
        width: 430px;
        border: 1px solid #ACD8F0;
        overflow: auto;
    }
</style>

<body>
    <div id="ws_support"></div>
    <div id="wrapper">
        <div id="menu">
            <h3 class="welcome">PHP Web Chat</h3>
        </div>
        <div id="chatbox"></div>
        <!-- <textarea style="text-align: center;" id="chatbox" name="w3review" rows="20" cols="70" readonly></textarea> -->
        Name <input name="txtName" type="text" id="txtName" size="10" />
        Message <input name="txtMessage" type="text" id="txtMessage" size="35" placeholder="" />
        <input name="btnSend" type="button" id="btnSend" value="Send" />
    </div>
</body>

</html>

<script language="javascript">
    var socket;

    function webSocketSupport() {
        if (browserSupportsWebSockets() === false) {
            $('#ws_support').html('<h2>Sorry! Your web browser does not supports web sockets</h2>');
            $('#wrapper').hide();
            return;
        }

        // Open Connection
        socket = new WebSocket('ws://localhost:8080');

        socket.onopen = function(e) {
            writeMessage("You have have successfully connected to the server");
        };

        socket.onmessage = function(e) {
            onMessage(e)
        };

        socket.onerror = function(e) {
            onError(e)
        };

    }

    function onMessage(e) {
        writeMessage('<span style="color: blue;"> ' + e.data + '</span>');
    }

    function onError(e) {
        writeMessage('<span style="color: red;">Error!!</span> ' + e.data);
    }

    function doSend() {

        if ($('#txtName').val() == '') {
            alert('Enter your [Name]');
            $('#txtName').focus();
            return '';
        } else if ($('#txtMessage').val() == '') {
            alert('Enter your [Message]');
            $('#txtMessage').focus();
            return '';
        }

        var strMessage = '@<b>' + $('#txtName').val() + '</b>: ' + $('#txtMessage').val();
        socket.send(strMessage);
        writeMessage(strMessage);

        $('#txtMessage').val('');
        $('#txtMessage').focus();
    }

    function writeMessage(message) {
        $('#chatbox').append( message + '<br>');
    }

    function browserSupportsWebSockets() {
        if ("WebSocket" in window) {
            return true;
        } else {
            return false;
        }
    }

    $(document).ready(function() {
        webSocketSupport();
    });

    $('#btnSend').click(function() {
        doSend();
    });
</script>