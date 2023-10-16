<?php
include("sql.php");
include("bpdata.php");
include("crud_zen.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';

    $tableData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
    $tableData_Json = json_decode($tableData, true);
    // ดำเนินการกับข้อมูลตามที่คุณต้องการ
    // เช่น บันทึกลงฐานข้อมูลหรือส่งอีเมล
    // ใช้คลาส InsertData เพื่อ insert ข้อมูล
    try {
        $sqlQueries = new SQLQueries();

        // ใช้เมทอด scanSQL() เพื่อรับคำสั่ง SQL ตาม $queryId
        $sqlQuery = $sqlQueries->scanSQL($queryIdHD);
        if ($sqlQuery !== null) {
            $insertData = new CRUDDATA('mysql', 'localhost', 'test', 'root', '1234');
            $insertData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            if ($insertData->insertRecordMultiple($tableData_Json, $sqlQuery, $condition))
            {
                $response = array(
                    'message' => 'Data received successfully',
                    'status' => 'success'
                );
                $insertData->data_commit->commit();
            } else {
                $response = array(
                    'message' => $insertData->message_log,
                    'status' => 'error'
                );
                $insertData->data_commit->rollBack();
            }
        } else {
            $response = array(
                'message' => 'ไม่พบคำสั่ง SQL สำหรับ $queryId ที่ระบุ',
                'status' => 'error',
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    } catch (Exception $e) {
        $response = array(
            'message' => $e->getMessage(),
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
