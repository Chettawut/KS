<?php
	header('Content-Type: application/json');
	include('../../conn.php');
    
    date_default_timezone_set("Asia/Bangkok");
    
    

    $strSQL = "DELETE FROM user ";    
    $strSQL .= "WHERE username= '".$_POST["editusername"]."' ";

    
	$query = mysqli_query($conn,$strSQL);
    
    // echo $strSQL;


        if($query) {
            echo json_encode(array('status' => '1','message'=> 'ลบผู้ใช่ '.$_POST["editfirstname"].' สำเร็จ'));
        }
        else
        {
            echo json_encode(array('status' => '0','message'=> 'Error insert data!'));
        }
    
        mysqli_close($conn);
?>