<?php
	header('Content-Type: application/json');
	include('../conn.php');

	$sql = "SELECT count(cuscode) as countcus ";
	$sql .= "FROM customer  ";   
	$sql .= "where trackno != ''  ";   

	$query = mysqli_query($conn,$sql);

	// echo $sql;

	$json_result=array(
        "countcus" => array()
		);
		
        while($row = $query->fetch_assoc()) {
            array_push($json_result['countcus'],$row["countcus"]);
        }
        echo json_encode($json_result);



?>