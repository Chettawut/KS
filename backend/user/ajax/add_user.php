<?php
	header('Content-Type: application/json');
    include('../../conn.php');
    date_default_timezone_set('Asia/Bangkok');
    $password = password_hash($_POST['userpassword'], PASSWORD_DEFAULT);
    $StrSQL = "INSERT INTO user (`username`, `password`, `firstname`, `lastname`, `tel` ,`email`, `type`, `status`,`date`) ";
    $StrSQL .= "VALUES (";
    $StrSQL .= "'".$_POST["userusername"]."','".$password."','".$_POST["userfirstname"]."','".$_POST["userlastname"]."','".$_POST["usertel"]."' ";
    $StrSQL .= ",'".$_POST["useremail"]."','".$_POST["usertype"]."','Y','".date("Y-m-d H:i:s")."' ";
    $StrSQL .= ")";
    $query = mysqli_query($conn,$StrSQL);
    
    // echo $StrSQL;


        if($query) {
            echo json_encode(array('status' => '1','message'=> 'เพิ่มผู้ใช้ '.$_POST["userfirstname"].' สำเร็จ'));
        }
        else
        {
            echo json_encode(array('status' => '0','message'=> 'Error insert data!'));
        }
    
        mysqli_close($conn);
?>