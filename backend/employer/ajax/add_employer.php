<?php
header('Content-Type: application/json');
include('../../conn.php');
date_default_timezone_set('Asia/Bangkok');
$path = dirname(__FILE__, 4);
$pathUpload = "//uploads//";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES["file"])) {
    $idcode = $_POST["idcode"];
    $empname = $_POST["empname"];
    $lastname = $_POST["lastname"];

    $pathDocument = $idcode."//";
    $filepath = $path.$pathUpload.$pathDocument;
    if (!file_exists($path.$pathUpload)) {
        mkdir($path.$pathUpload, 0777);
    }
    if (!file_exists($filepath)) {
        mkdir($filepath, 0777);
    }
    $file = $_FILES["file"];
    $document = array();
    for ($i = 0; $i < count($file["name"]); $i++) {
        $file_temp = $file["tmp_name"][$i];
        $file_name = $file["name"][$i];
        if(file_exists($filepath . $file_name)) continue;

        if (move_uploaded_file($file_temp, $filepath . $file_name)) {
            if (file_exists($filepath . $file_name) != 1)  continue;
                
            array_push($document, array( "url" => $pathUpload.$pathDocument.$file_name, "attname" => $file_name) ); 
        } 
    }
    $sql = "select empcode from `option`";
    $query = mysqli_query($conn,$sql);
    $res = $query->fetch_assoc();
 
    $qcode = $res ? (int)($res["empcode"])+1 : 1;   
    $_form = $_POST;
    $_form["empcode"] = sprintf("EM%04s",$qcode);
    $_form["regisdate"] = date("Y-m-d"); 
    $_form["status"] = "Y";
    $_field = array();
    $_value = array();
    foreach ( $_form as $k => $v )   {
        array_push($_field, $k);
        array_push($_value, $v); 
    }
    $col = join(",",$_field);
    $val = join("','",$_value); 
    
    //$conn->autocommit(FALSE); 
    $conn->begin_transaction();
    try {  
        $conn->query("INSERT INTO employer($col) VALUES ('$val')");  
        $conn->query("UPDATE `option` SET empcode = $qcode"); 

        foreach ( $document as $i => $v ){ 
            $percode = $_form["empcode"]; 
            $url = $v["url"];
            $attname = $v["attname"];
            $attno = $i+1;
            $sql = "INSERT INTO attachment(percode,attno,attname,url) VALUES ('$percode', $attno, '$attname', '$url')";
            $result = $conn->query($sql);     
            //echo $sql;
            //if($result) throw new Exception("Statement query error.");
        }  
        $conn->commit();
        mysqli_close($conn); 

        header('Status: 200');
        echo json_encode(array('status' => '1','message'=> "เพิ่มเคสลูกค้า $empname $lastname สำเร็จ"));
    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        mysqli_close($conn);

        header('Status: 400');
        echo json_encode(array('status' => '0','message'=> 'Error insert data!'));
        //throw $exception;
    } 
} else {
    echo "Incorrect Parameter";
}
exit;