<?php
	session_start();
	header('Content-Type: application/json');
	include('../../conn.php'); 
	if (!isset($_SESSION['loggedin'])) {
		http_response_code(400);
		echo json_encode(array('status' => '0', 'message' => 'Session not found.'));
		die;
	}	
	$sql = "SELECT * FROM employer;"; 
	$query = mysqli_query($conn,$sql);
	// Fetch all
	$res = $query->fetch_all(MYSQLI_ASSOC); //MYSQLI_ASSOC

	// Free result set
	$query->free_result();

	$conn->close();
  	echo json_encode($res);  
	exit;
?>