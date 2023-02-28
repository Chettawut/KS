<?php
session_start();
header('Content-Type: application/json');
include('../../conn.php');

if (!isset($_SESSION['loggedin'])) {
	http_response_code(400);
	echo json_encode(array('status' => '0', 'message' => 'Session not found.'));
	die;
}
try {
	$sql = "SELECT * FROM employer;";
	$stmt = $conn->prepare($sql);
	if (!$stmt->execute()) throw new mysqli_sql_exception("Insert data error.");

	$resultSet = $stmt->get_result();
	$res = $resultSet->fetch_all(MYSQLI_ASSOC);
 
	$stmt->free_result();

	$conn->close();
	echo json_encode($res);
} catch (Exception $e) {
	$conn->close();

	http_response_code(400);
	echo json_encode(array('status' => '0', 'message' => "Sql fail."));	
	die;
} 
exit;
