<?php
header('Content-Type: application/json');
include('../../conn.php');

session_start();
if (!isset($_SESSION['loggedin'])) {
    http_response_code(400);
    echo json_encode(array('status' => '0', 'message' => 'Session not found.'));
    die;
}

try {
	$socode = $_GET["g"];
	$sql = " 
	select 
	sd.*, p.productname
	from sodetail sd
	inner join productlists p on p.id = sd.productlistid 
	where socode = ?
	order by sd.id asc;";
	$stmt = mysqli_prepare($conn, $sql); // prepare
	mysqli_stmt_bind_param($stmt, 's', $socode); // bind array at once
	if (!mysqli_stmt_execute($stmt)) throw new mysqli_sql_exception("get data filed.");
 

	$resultSet = mysqli_stmt_get_result($stmt); //$stmt->get_result();
	$res = $resultSet->fetch_all(MYSQLI_ASSOC); //MYSQLI_ASSOC

	// Free result set
	$stmt->free_result();
 
	echo json_encode($res);
} catch (mysqli_sql_exception $e) {  
	http_response_code(400);
	echo json_encode(array('status' => '0', 'message' => "Sql fail."));
}
finally
{
	mysqli_close($conn);
}
exit;
