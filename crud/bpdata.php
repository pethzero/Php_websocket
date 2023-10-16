<?php
class bindParamData {
    public static function bindParams($stmt, $data, $condition) {
        switch ($condition) {
            case 'DT000':
                $stmt->bindParam(':recno', $data['recno']);
                break;
            case '001':
                $stmt->bindParam(':name', $data['name']);
                $stmt->bindParam(':detail', $data['detail']);
                $stmt->bindParam(':remark', $data['remark']);
                $stmt->bindParam(':startd', $data['dateAct']);
                $stmt->bindParam(':warmd', $data['dateWarn']);
                $stmt->bindParam(':ownername', $data['ownername']);
                break;
            case '001_NEW':
                    $stmt->bindParam(':name', $data['name']);
                    $stmt->bindParam(':detail', $data['detail']);
                    $stmt->bindParam(':remark', $data['remark']);
                    $stmt->bindParam(':startd', $data['dateAct']);
                    $stmt->bindParam(':warmd', $data['dateWarn']);
                    $stmt->bindParam(':ownername', $data['ownername']);
                    $stmt->bindParam(':location', $data['location']);
                    break;
            case '002':
                $stmt->bindParam(':recno', $data['recno']);
                $stmt->bindParam(':name', $data['name']);
                $stmt->bindParam(':detail', $data['detail']);
                $stmt->bindParam(':remark', $data['remark']);
                $stmt->bindParam(':startd', $data['dateAct']);
                $stmt->bindParam(':warmd', $data['dateWarn']);
                $stmt->bindParam(':ownername', $data['ownername']);
                break;
            case '002_NEW':
                    $stmt->bindParam(':recno', $data['recno']);
                    $stmt->bindParam(':name', $data['name']);
                    $stmt->bindParam(':detail', $data['detail']);
                    $stmt->bindParam(':remark', $data['remark']);
                    $stmt->bindParam(':startd', $data['dateAct']);
                    $stmt->bindParam(':warmd', $data['dateWarn']);
                    $stmt->bindParam(':ownername', $data['ownername']);
                    $stmt->bindParam(':address', $data['address']);
                    $stmt->bindParam(':status', $data['status']);
                    break;
            case 'DATEBE':
                    $stmt->bindParam(':ABEGIN', $data['datebegin']);
                    $stmt->bindParam(':AEND', $data['dateend']);
                    break;
            // เพิ่มเงื่อนไขเพิ่มเติมตามความต้องการ
            default:
                // ไม่มีเงื่อนไขที่ตรงกัน
                break;
        }
    }
}