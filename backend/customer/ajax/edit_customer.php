<?php
	header('Content-Type: application/json');
	include('../../conn.php');
    
    date_default_timezone_set("Asia/Bangkok");
    
    $strSQL = "UPDATE customer SET ";
    $strSQL .= "cusname='".$_POST["cusname"]."',lastname='".$_POST["lastname"]."' ";
    $strSQL .= ",titlename='".$_POST["titlename"]."',cusdate='".$_POST["cusdate"]."',code='".$_POST["code"]."' ";
    $strSQL .= ",codeno='".$_POST["codeno"]."',plateno='".$_POST["plateno"]."',credittype='".$_POST["credittype"]."' ";
    $strSQL .= ",oldfinance='".$_POST["oldfinance"]."',closeprice='".$_POST["closeprice"]."',closevender='".$_POST["closevender"]."' ";
    $strSQL .= ",diff='".$_POST["diff"]."',branch='".$_POST["branch"]."',province='".$_POST["province"]."' ";
    $strSQL .= ",followdate='".$_POST["followdate"]."',bookdate='".$_POST["bookdate"]."',trackno='".$_POST["trackno"]."' ";
    $strSQL .= ",s_date = '".date("Y-m-d")."',s_time='".date("H:i:s")."' ";
    $strSQL .= "WHERE cuscode= '".$_POST["cuscode"]."' ";
    
	$query = mysqli_query($conn,$strSQL);

    
    // echo $strSQL;


        if($query) {
            echo json_encode(array('status' => '1','message'=> 'เคสลูกค้า '.$_POST["cusname"].' '.$_POST["lastname"].' สำเร็จ'));
        }
        else
        {
            echo json_encode(array('status' => '0','message'=> 'Error insert data!'));
        }
    
        mysqli_close($conn);
?>