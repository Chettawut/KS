<?php
header('Content-Type: application/json');
include('../../conn.php');

session_start();
if (!isset($_SESSION['loggedin'])) {
    http_response_code(400);
    echo json_encode(array('status' => '0', 'message' => 'Session not found.'));
    die;
}

$path = dirname(__FILE__, 3);
$pathUpload = "//uploads//";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST, EXTR_OVERWRITE, "_"); 
    $sql = "select * from employer where idcode = '$idcode' and empcode != '$empcode' ";
    $query = mysqli_query($conn, $sql);
    $res = $query->fetch_assoc();
    if (!empty($res["idcode"])) {
        mysqli_close($conn);

        http_response_code(400);
        echo "รหัสบัตรประชาชนซ้ำ";
        die();
    }

    $sql = "select * from employer where passport = '$passport' and empcode != '$empcode' ";
    $query = mysqli_query($conn, $sql);
    $res = $query->fetch_assoc();
    if (!empty($res["passport"])) {
        mysqli_close($conn);

        http_response_code(400);
        echo "พาสปอร์ตเซ้ำ";
        die();
    }

    $pathDocument = $empcode . "//";
    $filepath = $path . $pathUpload . $pathDocument;

    if (!file_exists($path . $pathUpload)) {
        mkdir($path . $pathUpload, 0777);
    }
    if (!file_exists($filepath)) {
        mkdir($filepath, 0777);
    }
    $conn->begin_transaction();
    try {

        $file_deleted = json_decode($fileDelete, true);
        if (!empty($file_deleted)) {
            foreach ($file_deleted as $i => $v) {
                $c = $v["code"]; 
                $p = $v["url"];
                if (file_exists($path .  $p)) {
                    unlink($path . $p);
                }
                
                $sql  = "DELETE FROM attachment WHERE code = ?";
                $stmt = $conn->prepare($sql); // prepare
                $stmt->bind_param('s', $c); // bind array at once
                if (!$stmt->execute()) throw new Exception("Update data error.");
            }
        }

        $file_data = json_decode($fileData, true);
        if (!empty($file_data)) {
            foreach ($file_data as $i => $v) {
                $file_code = $v["code"];
                $file_attname = $v["attname"];
                $file_name = $v["file_name"];
                
                $file_oldName = $v["fname"];
                $file_url = $v["url"];                 
                if(!isset($file_name) && !empty($_FILES["file$file_code"])){
                    $file_attach = $_FILES["file$file_code"]; 
                    $file_temp = $file_attach["tmp_name"];
                    $file_name = $file_attach["name"];
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    
                    if (file_exists($path . $file_url)) unlink($path . $file_url);
                    
                    $file_url = $pathUpload . $empcode . "//" . $file_oldName . '.'. $ext;
                    if (!move_uploaded_file($file_temp, $path . $file_url)) {
                        throw new Exception("File exists.");
                        exit;
                    }                    
                }
                $sql = "UPDATE attachment SET attname = ?, url = ?  WHERE code = ?"; // sql 
                $stmt = $conn->prepare($sql); // prepare
                $stmt->bind_param('sss', $file_attname, $file_url, $file_code); // bind array at once
                if (!$stmt->execute()) throw new Exception("Insert data error.");
            }
        }

        $document = array();
        if (!empty($_FILES["file"])) {
            $file = $_FILES["file"];  
            $sql = "select max(attno) m from attachment where percode = '$empcode' ";
            $query = mysqli_query($conn, $sql);
            $res = $query->fetch_assoc();
            $max_attno = $res ? (int)($res["m"]) + 1 : 1;

            for ($i = 0; $i < count($file["name"]); $i++) {
                $file_temp = $file["tmp_name"][$i];
                $f = $file["name"][$i];
                $ext = pathinfo($f, PATHINFO_EXTENSION);
                $file_name = sprintf("$empcode-%02s.$ext", $i + $max_attno);

                //if (file_exists($filepath . $file_name)) continue;

                if (!move_uploaded_file($file_temp, $filepath . $file_name)) {
                    throw new Exception("File exists.");
                    exit;
                }
                if (!file_exists($filepath . $file_name)) continue;
                $att_name = $attname[$i];
                array_push($document, array("url" => $pathUpload . $pathDocument . $file_name, "attname" => $att_name, "attno" => $i + $max_attno));
            }
        }
        //var_dump($document);
        ///throw new Exception("error test");
        // exit;
        $sql  = "UPDATE employer SET empname=?,lastname=?,titlename=?,idcode=?,empbirth=?,passport=? where empcode = ?";
        $stmt = $conn->prepare($sql); // prepare
        $data = [$empname, $lastname, $titlename, $idcode, $empbirth, $passport, $empcode];
        $stmt->bind_param(str_repeat('s', count($data)), ...$data); // bind array at once
        if (!$stmt->execute()) throw new Exception("Update data error.");

        foreach ($document as $i => $v) {
            $percode = $empcode;
            extract($v);
            $sql = "INSERT INTO attachment(percode,attno,attname,url) VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql); // prepare
            $data = [$empcode, $v["attno"], $v["attname"], $v["url"]];
            $stmt->bind_param('siss', ...$data); // bind array at once
            if (!$stmt->execute()) throw new Exception("Update data error.");
            //echo $sql;
            //if($result) throw new Exception("Statement query error.");
        }
        $conn->commit();
        mysqli_close($conn);

        header('Status: 200');
        echo json_encode(array('status' => '1', 'message' => "แก้ไข $empname $lastname สำเร็จ"));
    } catch (Exception $exception) {
        $conn->rollback();
        mysqli_close($conn);

        http_response_code(400);
        echo json_encode(array('status' => '0', 'message' => 'Error insert data!'));
        die;
        //throw $exception;
    }
} else {
    echo "Incorrect Parameter";
}
exit;
