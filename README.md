# Php_websocket
วิธีลง
อ่านอิงค์ ความรู้
https://www.thaicreate.com/php/php-websockets.html

http://socketo.me/

ปัญหาที่เคยพบ
1.ใส่ข้อความ composer.json ที่หลัง
  "autoload": {
        "psr-0": {
            "MyApp": "src"
        }
    },
 
  แก้ไขโดย composer dump-autoload

2.อย่าลืมรัน php chat-server.php 