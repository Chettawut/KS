<?php
	header('Content-Type: application/json');
	include('../../conn.php');
	
	$strSQL = "SELECT * FROM `user` where username = '".$_POST['idcode']."'";
	$query = mysqli_query($conn,$strSQL);
	
	$json_result=array(
		"code" => array(),
        "username" => array(),
		"password" => array(),
		"firstname" => array(),
		"lastname" => array(),
		"tel" => array(),
		"email" => array(),
		"status" => array(),
		"type" => array()
		
        );
        while($row = $query->fetch_assoc()) {
			array_push($json_result['code'],$row["code"]);
            array_push($json_result['username'],$row["username"]);
			array_push($json_result['password'],$row["password"]);
			array_push($json_result['firstname'],$row["firstname"]);
			array_push($json_result['lastname'],$row["lastname"]);
			array_push($json_result['tel'],$row["tel"]);
			array_push($json_result['email'],$row["email"]);
			array_push($json_result['status'],$row["status"]);
			array_push($json_result['type'],$row["type"]);
        }
        echo json_encode($json_result);



		mysqli_close($conn);
?>