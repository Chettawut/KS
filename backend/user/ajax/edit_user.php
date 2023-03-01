<?php
	header('Content-Type: application/json');
	include('../../conn.php');
    
    date_default_timezone_set("Asia/Bangkok");
    
    
    
    $strSQL = "UPDATE user SET ";
    $strSQL .= "username='".$_POST["editusername"]."',firstname='".$_POST["editfirstname"]."',lastname='".$_POST["editlastname"]."' ";
    $strSQL .= ",email='".$_POST["editemail"]."',type='".$_POST["edittype"]."',status='".$_POST["editstatus"]."',date='".date("Y-m-d H:i:s")."'";
    $strSQL .= "WHERE code= '".$_POST["code"]."' ";

    
	$query = mysqli_query($conn,$strSQL);
    
    // echo $strSQL;


        if($query) {
            echo json_encode(array('status' => '1','message'=> 'แก้ไขผู้ใช้ '.$_POST["editfirstname"].' สำเร็จ'));
        }
        else
        {
            echo json_encode(array('status' => '0','message'=> 'Error insert data!'));
        }
    
        mysqli_close($conn);
?>