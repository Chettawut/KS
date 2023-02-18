<?php
	header('Content-Type: application/json');
	include('../conn.php');

	$sql = "SELECT count(cuscode) as countcus ";
	$sql .= "FROM customer  ";   

	$query = mysqli_query($conn,$sql);

	$row = $query->fetch_assoc();

	$sql = "SELECT count(cuscode) as countcus ";
	$sql .= "FROM customer  ";   
	$sql .= "where trackno != ''  ";   

	$query2 = mysqli_query($conn,$sql);

	$row2 = $query2->fetch_assoc();
	// echo $sql;

	$json_result=array(
        "countcus" => array()
		);
		
            array_push($json_result['countcus'],($row2["countcus"]*100)/$row["countcus"]);

        echo json_encode($json_result);



?>