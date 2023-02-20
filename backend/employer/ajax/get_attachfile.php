<?php
	header('Content-Type: application/json');
	include('../../conn.php');
	$percode = $_GET["empcode"];
	$sql = "SELECT * from attachment a where percode = '$percode';"; 
	$query = mysqli_query($conn,$sql);
	// Fetch all
	$res = $query->fetch_all(MYSQLI_ASSOC); //MYSQLI_ASSOC

	// Free result set
	$query->free_result();

	$conn->close();
  	echo json_encode($res);  
	exit;
?>