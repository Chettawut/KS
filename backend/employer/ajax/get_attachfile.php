<?php
	header('Content-Type: application/json');
	include('../../conn.php');
	session_start();

	if (!isset($_SESSION['loggedin'])) {
		http_response_code(400);
		echo json_encode(array('status' => '0', 'message' => 'Session not found.'));
		die;
	}	
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