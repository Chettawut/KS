<?php
	header('Content-Type: application/json');
    include('../../conn.php');
    date_default_timezone_set('Asia/Bangkok');
    
    $StrSQL = "INSERT INTO customer (cusname,lastname,titlename, cusdate, code, codeno ";
    $StrSQL .= ",plateno,credittype, oldfinance, closeprice, closevender, diff, branch, province, s_date, s_time) ";
    $StrSQL .= "VALUES (";
    $StrSQL .= "'".$_POST["add_cusname"]."','".$_POST["add_lastname"]."','".$_POST["add_titlename"]."','".$_POST["add_cusdate"]."' ";
    $StrSQL .= ",'".$_POST["add_code"]."','".$_POST["add_codeno"]."','".$_POST["add_plateno"]."','".$_POST["add_credittype"]."','".$_POST["add_oldfinance"]."' ";
    $StrSQL .= ",'".$_POST["add_closeprice"]."','".$_POST["add_closevender"]."','".$_POST["add_diff"]."','".$_POST["add_branch"]."','".$_POST["add_province"]."' ";
    $StrSQL .= ",'".date("Y-m-d")."','".date("H:i:s")."' ";    
    $StrSQL .= ")";
    $query = mysqli_query($conn,$StrSQL);

    

    // echo $StrSQL;


        if($query) {
            echo json_encode(array('status' => '1','message'=> 'เพิ่มเคสลูกค้า '.$_POST["add_cusname"].' '.$_POST["add_lastname"].' สำเร็จ'));
        }
        else
        {
            echo json_encode(array('status' => '0','message'=> 'Error insert data!'));
        }
    
        mysqli_close($conn);
?>