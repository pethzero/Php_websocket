<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }



    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                // $client->send($msg);
                if ($data['action'] === 'databaseSelect') {
                    $this->onDatabaseSelect($from, $data);
                }
            }
        }
    }

    public function onDatabaseSelect(ConnectionInterface $from, $data)
    {
        echo sprintf(
            'ํYes' . "\n",
            $from->resourceId,
        );
        $from->send($data); // ส่งข้อมูลกลับไปยังลูกค้า (หากต้องการ)
    }



    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    //
    public function sendNotification($data)
    {
        foreach ($this->clients as $client) {
            $client->send($data); // ส่งข้อมูลไปยังเว็บไคลเอนต์ที่เชื่อมต่อ
        }
    }
}
