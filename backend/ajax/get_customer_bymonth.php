<?php
	header('Content-Type: application/json');
	include('../conn.php');

	$month = date('m');
	$year = date('Y');
	$sql = "SELECT count(cuscode) as countcus ";
	$sql .= "FROM customer  ";   
	$sql .= "where MONTH(cusdate)= '".$month."' and YEAR(cusdate) = '".$year."' ";   
	

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