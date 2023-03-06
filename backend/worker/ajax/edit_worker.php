<?php
header('Content-Type: application/json');
include('../../conn.php');

session_start();
if (!isset($_SESSION['loggedin'])) {
    http_response_code(400);
    echo json_encode(array('status' => '0', 'message' => 'Session not found.'));
    die;
}

date_default_timezone_set("Asia/Bangkok");

$path = dirname(__FILE__, 3);
$pathUpload = "//uploads//";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST, EXTR_OVERWRITE, "_");

    $FILE_REQUIRED = array("application/pdf", "image/jpg", "image/png", "image/jpeg");

    $sql = "select * from worker where idcode = '$idcode' and wkcode != '$wkcode' ";
    $query = mysqli_query($conn, $sql);
    $res = $query->fetch_assoc();

    if (!empty($res["idcode"])) {
        mysqli_close($conn);

        http_response_code(400);
        echo "รหัสบัตรประชาชนซ้ำ";
        die();
    }

    $sql = "select * from worker where passport = '$passport' and wkcode != '$wkcode' ";
    $query = mysqli_query($conn, $sql);
    $res = $query->fetch_assoc();
    if (!empty($res["passport"])) {
        mysqli_close($conn);

        http_response_code(400);
        echo "พาสปอร์ตเซ้ำ";
        die();
    }

    $pathDocument = $wkcode . "//";
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
                if (!isset($file_name) && !empty($_FILES["file$file_code"])) {

                    $file_attach = $_FILES["file$file_code"];
                    $file_temp = $file_attach["tmp_name"];
                    $file_name = $file_attach["name"];
                    $file_type = $file_attach["type"];
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);

                    if (!in_array($file_type, $FILE_REQUIRED)) {
                        throw new Exception("File attach incorrect.");
                        die;
                    }

                    if (file_exists($path . $file_url)) unlink($path . $file_url);

                    $file_url = $pathUpload . $wkcode . "//" . $file_oldName . '.' . $ext;
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
            $sql = "select max(attno) m from attachment where percode = '$wkcode' ";
            $query = mysqli_query($conn, $sql);
            $res = $query->fetch_assoc();
            $max_attno = $res ? (int)($res["m"]) + 1 : 1;

            for ($i = 0; $i < count($file["name"]); $i++) {
                $file_temp = $file["tmp_name"][$i];
                $f = $file["name"][$i];
                $t = $file["type"][$i];
                $ext = pathinfo($f, PATHINFO_EXTENSION);
                $file_name = sprintf("$wkcode-%02s.$ext", $i + $max_attno);

                if (!in_array($t, $FILE_REQUIRED)) {
                    throw new Exception("File attach incorrect.");
                    die;
                }

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
        // var_dump($passportexpired);
        // throw new Exception("error test");
        // die;
        $sql  = "UPDATE worker SET wkname=?,lastname=?,titlename=?,idcode=?,wkbirth=?,passport=?,passportexpired=? where wkcode = ?";
        $stmt = $conn->prepare($sql); // prepare
        $data = [$wkname, $lastname, $titlename, $idcode, $wkbirth, $passport, $passportexpired, $wkcode];
        $stmt->bind_param(str_repeat('s', count($data)), ...$data); // bind array at once
        if (!$stmt->execute()) throw new Exception("Update data error.");
        // var_dump($data);
        // throw new Exception("error test");
        // die;
        if (!empty($empcode)) {
            $sql = "SELECT code, empcode FROM employment WHERE wkcode = ? AND status = 'Y'";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $wkcode);
            if (!$stmt->execute()) throw new Exception("Update data error.");

            $stmtResult = $stmt->get_result();
            $employmentExists = $stmtResult->fetch_assoc();
            // var_dump($employmentExists);
            // throw new Exception("Test value");
            // die;
            if (!empty($employmentExists["code"]) && $employmentExists["empcode"] != $empcode) {
                $sql  = "UPDATE employment SET status = 'N' where code = ?";
                $stmt = $conn->prepare($sql);
                $employment_code = $employmentExists["code"];
                $stmt->bind_param('i', $employment_code); // bind array at once
                if (!$stmt->execute()) throw new Exception("Update data error.");
            }

            if (($employmentExists["empcode"] ?? "") != $empcode) {
                $sql = "INSERT INTO employment(empcode, wkcode, employdate, employtime, status) VALUES (?, ?, ?, ?, 'Y')";
                $data = [$empcode, $wkcode, date("Y-m-d"), date("H:i:s")];
                $stmt = $conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($data)), ...$data);
                if (!$stmt->execute()) throw new mysqli_sql_exception("Insert data error.");
            }
        }else{
            $sql  = "UPDATE employment SET status = 'N' where wkcode = ?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param('s', $wkcode); // bind array at once
            if (!$stmt->execute()) throw new Exception("Update data error.");   
        }


        foreach ($document as $i => $v) {
            $percode = $wkcode;
            extract($v);
            $sql = "INSERT INTO attachment(percode,attno,attname,url) VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql); // prepare
            $data = [$wkcode, $v["attno"], $v["attname"], $v["url"]];
            $stmt->bind_param('siss', ...$data); // bind array at once
            if (!$stmt->execute()) throw new Exception("Update data error.");
        }
        $conn->commit();


        http_response_code(200);
        echo json_encode(array('status' => '1', 'message' => "แก้ไข $wkname $lastname สำเร็จ"));
    } catch (Exception $exception) {
        $conn->rollback(); 

        http_response_code(400);
        echo json_encode(array('status' => '0', 'message' => 'Error insert data!'));
        //throw $exception;
    }
    finally{
        mysqli_close($conn);
    }
} else {
    echo "Incorrect Parameter";
}
exit;
