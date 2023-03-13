<?php
header('Content-Type: application/json'); 
session_start();
if (!isset($_SESSION['loggedin'])) {
    http_response_code(400);
    echo json_encode(array('status' => '0', 'message' => 'Session not found.'));
    die;
}

date_default_timezone_set("Asia/Bangkok");

$path = dirname(__FILE__, 3);
$pathUpload = "//uploads//";

if ($_SERVER["REQUEST_METHOD"] == "POST") { //&& !empty($_FILES["file"])
    include('../../conn.php');
    extract($_POST, EXTR_OVERWRITE, "_");  

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    mysqli_autocommit($conn, false);
    //$conn->begin_transaction();
    try {
        $sql = "UPDATE somaster SET tel=? WHERE socode = ?"; // sql
        $data = [$tel, $socode]; // put your data into array
        $stmt = mysqli_prepare($conn,$sql); // prepare
        mysqli_stmt_bind_param($stmt,'ss', ...$data); // bind array at once
        if (!mysqli_stmt_execute($stmt)) throw new mysqli_sql_exception("Insert data error."); 
        
        $sql = "DELETE FROM sodetail WHERE socode = ?"; // sql
        $data = [$socode]; // put your data into array
        $stmt = mysqli_prepare($conn,$sql); // prepare
        mysqli_stmt_bind_param($stmt,'s', ...$data); // bind array at once
        if (!mysqli_stmt_execute($stmt)) throw new mysqli_sql_exception("Insert data error."); 
        
        foreach ($list as $i => $v) { 
            $sql = "INSERT INTO sodetail(socode,sono,wkcode,price,payment,remark,productlistid) VALUES (?,?,?,?,?,?,?)";
            $data = [$socode, ($i+1), $v["wkcode"], (float)$v["price"], $v["payment"], $v["remark"], $v["productlistid"]];
            $stmt = mysqli_prepare($conn, $sql); // prepare
            mysqli_stmt_bind_param($stmt,'sisdssi', ...$data); // bind array at once
            if (!mysqli_stmt_execute($stmt)) throw new mysqli_sql_exception("Insert data error.");
        } 
        
        mysqli_commit($conn);
        http_response_code(200);
        echo json_encode(array('status' => '1', 'message' => "เพิ่มใบรับงาน หรัส $socode สำเร็จ"));
    } catch (mysqli_sql_exception $e) {
        mysqli_rollback($conn);

        http_response_code(400);
        echo json_encode(array('status' => '0', 'message' => "Sql fail."));
        //throw $exception;
    } catch (Exception $e) {
        mysqli_rollback($conn);

        http_response_code(400);
        echo json_encode(array('status' => '0', 'message' => $e->getMessage()));
    }
    finally{ 
        mysqli_autocommit($conn, true); 
        mysqli_close($conn);
    }
} else {
    http_response_code(500);
    echo json_encode(array('status' => '0', 'message' => 'Internal error.'));
}
exit;
