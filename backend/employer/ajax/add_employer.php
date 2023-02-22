<?php
header('Content-Type: application/json');
include('../../conn.php');
date_default_timezone_set('Asia/Bangkok');
$path = dirname(__FILE__, 3);
$pathUpload = "//uploads//";

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {//&& !empty($_FILES["file"])
    $idcode = $_POST["idcode"];
    $passport = $_POST["passport"];
    $empname = $_POST["empname"];
    $lastname = $_POST["lastname"];
    $empbirth = $_POST["empbirth"];
    $titlename = $_POST["titlename"]; 
    $sql = "select * from employer where idcode = '$idcode' ";
    $query = mysqli_query($conn, $sql);
    $res = $query->fetch_assoc(); 
    if(!empty($res["idcode"])){
        mysqli_close($conn);

        http_response_code(400);
        echo "รหัสบัตรประชาชนซ้ำ";
        die(); 
    } 

    $pathDocument = $idcode . "//";
    $filepath = $path . $pathUpload . $pathDocument;

    if (!file_exists($path . $pathUpload)) {
        mkdir($path . $pathUpload, 0777);
    }
    if (!file_exists($filepath)) {
        mkdir($filepath, 0777);
    }

    $sql = "select empcode from `option`";
    $query = mysqli_query($conn, $sql);
    $res = $query->fetch_assoc();

    $qcode = $res ? (int)($res["empcode"]) + 1 : 1;
    $emp_code = sprintf("EM%04s", $qcode);
    $_form = $_POST;
    $empcode = $emp_code;
    $regisdate = date("Y-m-d");
    $status = "Y";
    // $_field = array();
    // $_value = array();
    // foreach ($_form as $k => $v) {
    //     array_push($_field, $k);
    //     array_push($_value, $v);
    // }
    // $col = join(",", $_field);
    // $val = join("','", $_value);


    
    $document = array();
    if(!empty($_FILES["file"])){ 
        $fileData = json_decode($_POST["fileData"], true);  
        $file = $_FILES["file"];
        for ($i = 0; $i < count($file["name"]); $i++) {
            $file_temp = $file["tmp_name"][$i];
            $f = $file["name"][$i];
            $ext = pathinfo($f, PATHINFO_EXTENSION);
            $file_name = sprintf("$emp_code-%02s.$ext", $i+1);
            if (file_exists($filepath . $file_name)) continue;

            if (move_uploaded_file($file_temp, $filepath . $file_name)) {
                if (file_exists($filepath . $file_name) != 1)  continue;
                $att_name = $fileData[$i]["attname"];
                array_push($document, array("url" => $pathUpload . $pathDocument . $file_name, "attname" => $att_name, "attno" => $i+1 ));
            }
        }
    }

    //$conn->autocommit(FALSE); 
    $conn->begin_transaction();
    try {
        $sql = "INSERT INTO employer (empcode,empname,lastname,titlename,idcode,empbirth,regisdate,passport,status) VALUES (?,?,?,?,?,?,?,?,'Y')"; // sql
        $data = [$empcode,$empname,$lastname,$titlename,$idcode,$empbirth,$regisdate,$passport]; // put your data into array
        $stmt = $conn->prepare($sql); // prepare
        $stmt->bind_param(str_repeat('s', count($data)), ...$data); // bind array at once
        $stmt->execute();
 
        $conn->query("UPDATE `option` SET empcode = $qcode");

        foreach ($document as $i => $v) {
            $percode = $emp_code;
            $url = $v["url"];
            $attname = $v["attname"];
            $attno = $i + 1;
            $sql = "INSERT INTO attachment(percode,attno,attname,url) VALUES ('$percode', $attno, '$attname', '$url')";
            $result = $conn->query($sql);
            //echo $sql;
            //if($result) throw new Exception("Statement query error.");
        }
        $conn->commit();
        mysqli_close($conn);

        header('Status: 200');
        echo json_encode(array('status' => '1', 'message' => "เพิ่มนายจ้าง $empname $lastname สำเร็จ"));
    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        mysqli_close($conn);

        header('Status: 400');
        echo json_encode(array('status' => '0', 'message' => 'Error insert data!'));
        //throw $exception;
    }
} else {
    echo "Incorrect Parameter";
}
exit;

 