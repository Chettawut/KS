<?php
	header('Content-Type: application/json');
	include('../../conn.php');
    
    date_default_timezone_set("Asia/Bangkok");   

    $path = dirname(__FILE__, 3);
    $pathUpload = "//uploads//";
   
    if ($_SERVER["REQUEST_METHOD"] == "POST" ) { 
        extract($_POST, EXTR_OVERWRITE, "_");  

        $sql = "select * from worker where idcode = '$idcode' and wkcode != '$wkcode' ";
        $query = mysqli_query($conn, $sql);
        $res = $query->fetch_assoc(); 
        if(!empty($res["idcode"])){
            mysqli_close($conn);
    
            http_response_code(400);
            echo "รหัสบัตรประชาชนซ้ำ";
            die(); 
        } 
 
        $sql = "select * from worker where passport = '$passport' and wkcode != '$wkcode' ";
        $query = mysqli_query($conn, $sql);
        $res = $query->fetch_assoc(); 
        if(!empty($res["passport"])){
            mysqli_close($conn);
    
            http_response_code(400);
            echo "พาสปอร์ตเซ้ำ";
            die(); 
        } 
 
        $sql = "select * from worker where wkcode = '$wkcode' ";
        $query = mysqli_query($conn, $sql);
        $worker = $query->fetch_assoc();  

        $_form = $_POST;   
        //var_dump("update attachment  set url = replace(url, '$old_idcode', '$idcode') where percode = '$wkcode'"); exit;
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
            if(!empty($file_deleted)){ 
                foreach($file_deleted as $i => $v){
                    $f_code = $v["code"]; 
                    $f_no = $v["attno"];
                    $f_fn = $v["url"];                
                    if(file_exists( $path .  $f_fn)){
                        unlink( $path . $f_fn);
                    } 
                     
                    $sql  = "DELETE FROM attachment WHERE code = ?";            
                    $stmt = $conn->prepare($sql); // prepare
                    $stmt->bind_param('s', $f_code); // bind array at once
                    if(!$stmt->execute()) throw new Exception("Update data error.");                     
                } 
            } 
            
            $file_rename = json_decode($fileRename, true); 
            if(!empty($file_rename)){ 
                foreach($file_rename as $i => $v){
                    $rename_code = $v["code"];
                    $rename_attname = $v["attname"];
                    $sql = "UPDATE attachment SET attname = ? WHERE code = ?"; // sql 
                    $stmt = $conn->prepare($sql); // prepare
                    $stmt->bind_param('ss', $rename_attname, $rename_code); // bind array at once
                    if(!$stmt->execute()) throw new Exception("Insert data error."); 
                } 
            } 

            $document = array();
            if(!empty($_FILES["file"])){ 
                $file = $_FILES["file"];
                $filed_data = json_decode($fileData, true); 
                
                $sql = "select max(attno) m from attachment where percode = '$wkcode' ";
                $query = mysqli_query($conn, $sql);
                $res = $query->fetch_assoc(); 
                $max_attno = $res ? (int)($res["m"]) + 1 : 1;
                
                for ($i = 0; $i < count($file["name"]); $i++) {
                    $file_temp = $file["tmp_name"][$i];
                    $f = $file["name"][$i];
                    $ext = pathinfo($f, PATHINFO_EXTENSION);
                    $file_name = sprintf("$wkcode-%02s.$ext", $i+$max_attno); 
                    
                    //if (file_exists($filepath . $file_name)) continue;
            
                    if (!move_uploaded_file($file_temp, $filepath . $file_name)) {
                        throw new Exception("File exists.");
                        exit;
                    }                        
                    if (!file_exists($filepath . $file_name)) continue;
                    $att_name = $filed_data[$i]["attname"]; 
                    array_push($document, array("url" => $pathUpload . $pathDocument . $file_name, "attname" => $att_name, "attno" => $i+$max_attno ));
                }    
                      
            }  
            //var_dump($document);
            ///throw new Exception("error test");
           // exit;
            $sql  = "UPDATE worker SET wkname=?,lastname=?,titlename=?,idcode=?,wkbirth=?,passport=? where wkcode = ?";            
            $stmt = $conn->prepare($sql); // prepare
            $data = [$wkname,$lastname,$titlename,$idcode,$wkbirth,$passport,$wkcode];
            $stmt->bind_param(str_repeat('s', count($data)), ...$data); // bind array at once
            if(!$stmt->execute()) throw new Exception("Update data error."); 

            foreach ($document as $i => $v) {
                $percode = $wkcode;
                extract($v);
                $sql = "INSERT INTO attachment(percode,attno,attname,url) VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql); // prepare
                $data = [$wkcode, $v["attno"], $v["attname"], $v["url"]];
                $stmt->bind_param('siss', ...$data); // bind array at once
                if(!$stmt->execute()) throw new Exception("Update data error.");   
            }
            $conn->commit();
            mysqli_close($conn);
    
            header('Status: 200');
            echo json_encode(array('status' => '1', 'message' => "แก้ไข $wkname $lastname สำเร็จ"));
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
