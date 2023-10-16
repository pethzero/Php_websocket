<?php

class Database
{
    private $engine;
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;
    public $message_log;

    public function __construct($engine, $host, $db_name, $username, $password)
    {
        $this->engine =  $engine;
        $this->host =  $host;
        $this->db_name =  $db_name;
        $this->username =  $username;
        $this->password =  $password;
    }
    public function connect()
    {
        $this->conn = null;

        try {
            if ($this->engine === 'mysql') {
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            } elseif ($this->engine === 'firebird') {
                $this->conn = new PDO("firebird:dbname={$this->host}:{$this->db_name};charset=NONE", $this->username, $this->password);
            }
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->message_log = 'Connection success';
        } catch (PDOException $e) {
            // echo "Connection failed: " . $e->getMessage();
            $this->message_log = "Connection failed: " . $e->getMessage(); // เก็บข้อความ error ในตัวแปร error_message
        }

        return $this->conn;
    }
}

class CRUDDATA
{
    private $engine;
    private $host;
    private $db_name;
    private $username;
    private $password;

    private $conn;
    public $data_commit;
    public $message_log;

    /////////////////////////////////////////////////////////  __construct  //////////////////////////////////////////////////////////////
    // __construct คือเมื่อ class CRUDDATA เรียกใช้งาน จะถูกใช้เลย
    public function __construct($engine, $host, $db_name, $username, $password)
    {
        $this->engine =  $engine;
        $this->host =  $host;
        $this->db_name =  $db_name;
        $this->username =  $username;
        $this->password =  $password;

        // $db = new Database('mysql', 'localhost', 'SAN', 'root', '1234');
        $db = new Database($engine, $host, $db_name, $username, $password);
        $this->conn = $db->connect();
        $this->message_log = $db->message_log;
        $this->conn->setAttribute(PDO::ATTR_AUTOCOMMIT, false); // ปิด Auto Commit
        $this->data_commit = $this->conn;
    }
    /////////////////////////////////////////////////////////  SELECT  //////////////////////////////////////////////////////////////

    public function SelectRecordFireBird($sqlQuery)
    {
        try {
            $data = array();
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                foreach ($row as $key => $value) {
                    if (is_string($value)) {
                        // ข้อมูลเป็น string
                        $row[$key] = iconv('TIS-620', 'UTF-8//TRANSLIT//IGNORE', $value);
                    }
                }
                $data[] = $row;
            }
            // ส่งค่าผลลัพธ์กลับ
            // return $result;
            return array('result' => $data, 'status' => true,  'db_connect' => $this->message_log, 'fecth_select' => 'select success');
        } catch (PDOException $e) {
            // $this->conn->rollBack(); // Rollback การ Transaction เมื่อเกิดข้อผิดพลาด
            return array('result' => [], 'status' => false, 'db_connect' => $this->message_log, 'fecth_select' => $e->getMessage());
            // return false;
        }
    }


    public function SelectRecordFireBirdCodition($dataArray, $sqlQuery, $condition)
    {
        try {
            $data = array();
            $stmt = $this->conn->prepare($sqlQuery);
            bindParamData::bindParams($stmt, $dataArray, $condition); // เรียกใช้งาน bindParamData
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                foreach ($row as $key => $value) {
                    if (is_string($value)) {
                        // ข้อมูลเป็น string
                        $row[$key] = iconv('TIS-620', 'UTF-8//TRANSLIT//IGNORE', $value);
                    }
                }
                $data[] = $row;
            }
            return array('result' => $data, 'status' => true,  'db_connect' => $this->message_log, 'fecth_select' => 'select success');
        } catch (PDOException $e) {
            // $this->conn->rollBack(); // Rollback การ Transaction เมื่อเกิดข้อผิดพลาด
            return array('result' => [], 'status' => false, 'db_connect' => $this->message_log, 'fecth_select' => $e->getMessage());
            // return false;
        }
    }

    public function SelectRecord($sqlQuery)
    {
        try {
            // $this->conn->beginTransaction(); // เริ่ม Transaction
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // ส่งค่าผลลัพธ์กลับ
            // return $result;
            return array('result' => $result, 'status' => true,  'db_connect' => $this->message_log, 'fecth_select' => 'select success');
        } catch (PDOException $e) {
            // $this->conn->rollBack(); // Rollback การ Transaction เมื่อเกิดข้อผิดพลาด
            return array('result' => [], 'status' => false, 'db_connect' => $this->message_log, 'fecth_select' => $e->getMessage());
            // return false;
        }
    }

    public function SelectRecordCondition($data, $sqlQuery, $condition)
    {
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            bindParamData::bindParams($stmt, $data, $condition); // เรียกใช้งาน bindParamData
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // ส่งค่าผลลัพธ์กลับ
            return array('result' => $result, 'status' => true,  'db_connect' => $this->message_log, 'fecth_select' => 'select success');
        } catch (PDOException $e) {
            // $this->conn->rollBack(); // Rollback การ Transaction เมื่อเกิดข้อผิดพลาด
            return array('result' => [], 'status' => false, 'db_connect' => $this->message_log, 'fecth_select' => $e->getMessage());
            // return false;
        }
    }

    public function checkExists($data, $sqlQuery, $condition)
    {
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            bindParamData::bindParams($stmt, $data, $condition); // เรียกใช้งาน bindParamData
            $stmt->execute();
            // $this->conn->commit(); // Commit การ Transaction
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['count'] > 0) {
                return array('status' => true, 'message' => 'RECNO exists');
            } else {
                return array('status' => false, 'message' => 'RECNO does not exist');
            }
        } catch (PDOException $e) {
            $this->conn->rollBack(); // Rollback การ Transaction เมื่อเกิดข้อผิดพลาด
            return array('status' => false, 'message' => $e->getMessage());
        }
    }
    /////////////////////////////////////////////////////////  INSERT  //////////////////////////////////////////////////////////////
    public function insertRecord($data, $sqlQuery, $condition)
    {
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            bindParamData::bindParams($stmt, $data, $condition); // เรียกใช้งาน bindParamData
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->message_log = "Error: " . $e->getMessage();
            return false;
        }
    }
    public function insertRecordMultiple($dataArray, $sqlQuery, $condition)
    {
        try {
            foreach ($dataArray as $data) {
                $stmt = $this->conn->prepare($sqlQuery);
                bindParamData::bindParams($stmt, $data, $condition); // เรียกใช้งาน bindParamData
                $stmt->execute();
            }
            return true;
        } catch (PDOException $e) {
            $this->message_log = "Error: " . $e->getMessage();
            return false;
        }
    }
    /////////////////////////////////////////////////////////  UPDATE  //////////////////////////////////////////////////////////////
    public function updateRecord($data, $sqlQuery, $condition)
    {
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            bindParamData::bindParams($stmt, $data, $condition); // เรียกใช้งาน bindParamData
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->message_log = "Error: " . $e->getMessage();
            return false;
        }
    }
    public function updateRecordMultiple($dataArray, $sqlQuery, $condition)
    {
        try {
            foreach ($dataArray as $data) {
                $stmt = $this->conn->prepare($sqlQuery);
                bindParamData::bindParams($stmt, $data, $condition); // เรียกใช้งาน bindParamData
                $stmt->execute();
            }
            return true;
        } catch (PDOException $e) {
            $this->message_log = "Error: " . $e->getMessage();
            return false;
        }
    }
    /////////////////////////////////////////////////////////  DETELE  //////////////////////////////////////////////////////////////
    public function deleteRecord($data, $sqlQuery, $condition)
    {
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            bindParamData::bindParams($stmt, $data, $condition); // เรียกใช้งาน bindParamData
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->message_log = "Error: " . $e->getMessage();
            return false;
        }
    }
    public function deleteRecordMultiple($dataArray, $sqlQuery, $condition)
    {
        try {
            foreach ($dataArray as $data) {
                $stmt = $this->conn->prepare($sqlQuery);
                bindParamData::bindParams($stmt, $data, $condition); // เรียกใช้งาน bindParamData
                $stmt->execute();
            }
            return true;
        } catch (PDOException $e) {
            $this->message_log = "Error: " . $e->getMessage();
            return false;
        }
    }
}
