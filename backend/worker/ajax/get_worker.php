<?php
	header('Content-Type: application/json');
	include('../../conn.php');
	
	$sql = "SELECT * FROM worker;"; 
	$query = mysqli_query($conn,$sql);
	// Fetch all
	$res = $query->fetch_all(MYSQLI_ASSOC); //MYSQLI_ASSOC

	// Free result set
	$query->free_result();

	$conn->close();
  	echo json_encode($res);  
	exit;
?>