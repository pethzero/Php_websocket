<?php
class SQLQueries
{
    private $sqlsreach = array();
    public function __construct()
    {
        // กำหนดคำสั่ง SQL สำหรับแต่ละค่า $queryIdHD ที่คุณต้องการ


        //APPPOINTMENT
        $this->sqlsreach['SELECT_HIS'] = "SELECT * FROM his ORDER BY RECNO DESC";
 
    }
    public function scanSQL($queryId)
    {
        if (array_key_exists($queryId, $this->sqlsreach)) {
            return $this->sqlsreach[$queryId];
        } else {
            return null;
        }
    }
}
