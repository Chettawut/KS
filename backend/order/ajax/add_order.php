<?php

header('Content-Type: application/json'); 

session_start();
if (!isset($_SESSION['loggedin'])) {
    http_response_code(400);
    echo json_encode(array('status' => '0', 'message' => 'Session not found.'));
    die;
} 
date_default_timezone_set('Asia/Bangkok'); 
 

if ($_SERVER["REQUEST_METHOD"] == "POST") { //&& !empty($_FILES["file"])
    include('../../conn.php');
    extract($_POST, EXTR_OVERWRITE, "_"); 
 
    $sql = "select socode rcode from `option`";
    $query = mysqli_query($conn, $sql);
    $res = $query->fetch_assoc();

    $rncode = $res ? (int)($res["rcode"]) + 1 : 1;
    $socode = sprintf("SO%s%05s", date("Y"), $rncode);
    $sodate = date("Y-m-d");
    $status = "รอชำระ";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    mysqli_autocommit($conn, false);
    //$conn->begin_transaction();
    try {
        $sql = "INSERT INTO somaster (socode,sodate,sotype,empcode,status,tel) VALUES (?,?,?,?,'รอชำระ',?)"; // sql
        $data = [$socode, $sodate, (int)$productgroupid, $empcode, $tel]; // put your data into array
        $stmt = mysqli_prepare($conn,$sql); // prepare
        mysqli_stmt_bind_param($stmt,'ssiss', ...$data); // bind array at once
        if (!mysqli_stmt_execute($stmt)) throw new mysqli_sql_exception("Insert data error."); 

        foreach ($list as $i => $v) { 
            $sql = "INSERT INTO sodetail(socode,sono,wkcode,price,payment,remark,productlistid) VALUES (?,?,?,?,?,?,?)";
            $data = [$socode, ($i+1), $v["wkcode"], (float)$v["price"], $v["payment"], $v["remark"], $v["productlistid"]];
            $stmt = mysqli_prepare($conn, $sql); // prepare
            mysqli_stmt_bind_param($stmt,'sisdssi', ...$data); // bind array at once
            if (!mysqli_stmt_execute($stmt)) throw new mysqli_sql_exception("Insert data error.");
        }

        $conn->query("UPDATE `option` SET socode = $rncode");  

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
