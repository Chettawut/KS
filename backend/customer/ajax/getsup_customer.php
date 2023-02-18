<?php
	header('Content-Type: application/json');
	include('../../conn.php');
	
	$strSQL = "SELECT cuscode,cusname,lastname,titlename,cusdate,code,codeno ";
	$strSQL .= ",plateno,credittype,oldfinance,closeprice,closevender,diff";
	$strSQL .= ",branch,province,followdate,bookdate,trackno ";
	$strSQL .= "FROM customer where cuscode = '".$_POST['idcode']."' ";   

	$query = mysqli_query($conn,$strSQL);
	
	$json_result=array(
        "cuscode" => array(),
		"cusname" => array(),
		"lastname" => array(),		
		"titlename" => array(),	
		"cusdate" => array(),	
		"code" => array(),	
		"codeno" => array(),
		"plateno" => array(),	
		"credittype" => array(),
		"oldfinance" => array(),
		"closeprice" => array(),	
		"closevender" => array(),	
		"diff" => array(),
		"branch" => array(),	
		"province" => array(),
		"followdate" => array(),		
		"bookdate" => array(),		
		"trackno" => array()
		
		);
		
        while($row = $query->fetch_assoc()) {
            array_push($json_result['cuscode'],$row["cuscode"]);
			array_push($json_result['cusname'],$row["cusname"]);
			array_push($json_result['lastname'],$row["lastname"]);
			array_push($json_result['titlename'],$row["titlename"]);
			array_push($json_result['cusdate'],$row["cusdate"]);
			array_push($json_result['code'],$row["code"]);
			array_push($json_result['codeno'],$row["codeno"]);
			array_push($json_result['plateno'],$row["plateno"]);
			array_push($json_result['credittype'],$row["credittype"]);
			array_push($json_result['oldfinance'],$row["oldfinance"]);
			array_push($json_result['closeprice'],$row["closeprice"]);
			array_push($json_result['closevender'],$row["closevender"]);
			array_push($json_result['diff'],$row["diff"]);
			array_push($json_result['branch'],$row["branch"]);
			array_push($json_result['province'],$row["province"]);
			array_push($json_result['followdate'],$row["followdate"]);
			array_push($json_result['bookdate'],$row["bookdate"]);
			array_push($json_result['trackno'],$row["trackno"]);			
        }
        echo json_encode($json_result);



?>