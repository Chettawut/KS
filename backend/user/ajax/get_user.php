<?php
	header('Content-Type: application/json');
	include('../../conn.php');

	$sql = "SELECT * FROM `user` order by type desc,date desc";
	$query = mysqli_query($conn,$sql);

	
	$json_result=array(
        "username" => array(),
		"firstname" => array(),
		"lastname" => array(),
		"tel" => array(),
		"email" => array(),
		"type" => array()
		
		);
		
        while($row = $query->fetch_assoc()) {
            array_push($json_result['username'],$row["username"]);
			array_push($json_result['firstname'],$row["firstname"]);
			array_push($json_result['lastname'],$row["lastname"]);
			array_push($json_result['tel'],$row["tel"]);
			array_push($json_result['email'],$row["email"]);
			array_push($json_result['type'],$row["type"]);
        }
        echo json_encode($json_result);



		mysqli_close($conn);
?>