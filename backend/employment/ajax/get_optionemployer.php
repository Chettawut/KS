<?php
	header('Content-Type: application/json');

	if ($_SERVER["REQUEST_METHOD"] == "GET" ) {
		include('../../conn.php');		
		$sql = "SELECT empcode id, concat(empname, ' ', lastname) text from employer"; 
		$query = mysqli_query($conn,$sql);
		// Fetch all
		$res = $query->fetch_all(MYSQLI_ASSOC); //MYSQLI_ASSOC

		// Free result set
		$query->free_result();

		$conn->close();
		echo json_encode($res);  		
	}	

	exit;
