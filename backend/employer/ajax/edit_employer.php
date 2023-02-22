<?php
	header('Content-Type: application/json');
	include('../../conn.php');
    
    date_default_timezone_set("Asia/Bangkok");   

    $path = dirname(__FILE__, 3);
    $pathUpload = "//uploads//";
   
    if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
        $idcode = $_POST["idcode"];
        $passport = $_POST["passport"];
        $empname = $_POST["empname"];
        $lastname = $_POST["lastname"];  
        $titlename = $_POST["titlename"];  
        $empbirth = $_POST["empbirth"];  
        $empcode = $_POST["empcode"];  
 
        $sql = "select * from employer where idcode = '$idcode' and empcode != '$empcode' ";
        $query = mysqli_query($conn, $sql);
        $res = $query->fetch_assoc(); 
        if(!empty($res["idcode"])){
            mysqli_close($conn);
    
            http_response_code(400);
            echo "รหัสบัตรประชาชนซ้ำ";
            die(); 
        } 
 
        $sql = "select * from employer where passport = '$passport' and empcode != '$empcode' ";
        $query = mysqli_query($conn, $sql);
        $res = $query->fetch_assoc(); 
        if(!empty($res["passport"])){
            mysqli_close($conn);
    
            http_response_code(400);
            echo "พาสปอร์ตเซ้ำ";
            die(); 
        } 
 
        $sql = "select * from employer where empcode = '$empcode' ";
        $query = mysqli_query($conn, $sql);
        $emplr = $query->fetch_assoc(); 
        $old_idcode = $emplr["idcode"];
        $old_passport = $emplr["passport"];



        $_form = $_POST;   
        //var_dump("update attachment  set url = replace(url, '$old_idcode', '$idcode') where percode = '$empcode'"); exit;
        $pathDocument = $idcode . "//";
        $filepath = $path . $pathUpload . $pathDocument;
        if( $idcode != $old_idcode){  
            rename($path . $pathUpload . $old_idcode. "//", $path . $pathUpload . $idcode. "//");
            $result = $conn->query("update attachment  set url = replace(url, '$old_idcode', '$idcode') where percode = '$empcode'");  
        }
        if (!file_exists($path . $pathUpload)) {
            mkdir($path . $pathUpload, 0777);
        }
        if (!file_exists($filepath)) {
            mkdir($filepath, 0777);
        }
        
         
        $fileDeleted = json_decode($_POST["fileDelete"], true); 
        if(!empty($fileDeleted)){ 
            foreach($fileDeleted as $i => $v){
                $f_code = $v["code"];
                $f_percode = $v["percode"];
                $f_no = $v["attno"];
                $f_fn = $v["url"];                
                if(file_exists( $path .  $f_fn)){
                    unlink( $path . $f_fn);
                } 
                $result = $conn->query("DELETE FROM attachment WHERE code = '$f_code' and percode = '$f_percode' and attno = '$f_no' "); 
            } 
        } 
         
        $fileRename = json_decode($_POST["fileRename"], true); 
        if(!empty($fileRename)){ 
            foreach($fileRename as $i => $v){
                $rename_code = $v["code"];
                $rename_attname = $v["attname"];
                $sql = "UPDATE attachment SET attname = ? WHERE code = ?"; // sql 
                $stmt = $conn->prepare($sql); // prepare
                $stmt->bind_param('ss', $rename_code, $rename_attname); // bind array at once
                $stmt->execute(); 
            } 
        } 

        $document = array();
        if(!empty($_FILES["file"])){ 
            $file = $_FILES["file"];
            $fileData = json_decode($_POST["fileData"], true); 
            var_dump($fileData); exit;
            $sql = "select max(attno) m from attachment where percode = '$empcode' ";
            $query = mysqli_query($conn, $sql);
            $res = $query->fetch_assoc(); 
            $max_attno = $res ? (int)($res["m"]) + 1 : 1;
            for ($i = 0; $i < count($file["name"]); $i++) {
                $file_temp = $file["tmp_name"][$i];
                $f = $file["name"][$i];
                $ext = pathinfo($f, PATHINFO_EXTENSION);
                $file_name = sprintf("$empcode-%02s.$ext", $i+$max_attno);
                if (file_exists($filepath . $file_name)) continue;
        
                if (move_uploaded_file($file_temp, $filepath . $file_name)) {
                    if (file_exists($filepath . $file_name) != 1) continue;
                    $att_name = $fileData[$i]["attname"];
                    array_push($document, array("url" => $pathUpload . $pathDocument . $file_name, "attname" => $att_name, "attno" => $i+$max_attno ));
                }
            }            
        }     
    
        $conn->begin_transaction();
        try {
            $sql = "
            UPDATE employer SET  
                empname = '$empname',
                lastname = '$lastname',
                titlename = '$titlename',
                idcode = '$idcode',
                empbirth = '$empbirth', 
                passport = '$passport' 
            where
                empcode = '$empcode'";            
            $conn->query($sql); 

            foreach ($document as $i => $v) {
                $percode = $empcode;
                $url = $v["url"];
                $attname = $v["attname"];
                $attno = $v["attno"];
                $sql = "INSERT INTO attachment(percode,attno,attname,url) VALUES ('$percode', $attno, '$attname', '$url')";
                $result = $conn->query($sql);
                //echo $sql;
                //if($result) throw new Exception("Statement query error.");
            }
            $conn->commit();
            mysqli_close($conn);
    
            header('Status: 200');
            echo json_encode(array('status' => '1', 'message' => "แก้ไข $empname $lastname สำเร็จ"));
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
?>