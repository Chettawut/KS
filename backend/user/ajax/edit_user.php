<?php
	header('Content-Type: application/json');
	include('../../conn.php');
    
    date_default_timezone_set("Asia/Bangkok");
    
    
    $password = password_hash($_POST['editpassword'], PASSWORD_DEFAULT);
    $strSQL = "UPDATE user SET ";
    $strSQL .= "username='".$_POST["editusername"]."',password='".$password."',firstname='".$_POST["editfirstname"]."',lastname='".$_POST["editlastname"]."',salecode='".$_POST["editsalecode"]."' ";
    $strSQL .= ",email='".$_POST["editemail"]."',type='".$_POST["edittype"]."',status='".$_POST["editstatus"]."',date='".date("Y-m-d H:i:s")."'";
    $strSQL .= "WHERE username= '".$_POST["editusername"]."' ";

    
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