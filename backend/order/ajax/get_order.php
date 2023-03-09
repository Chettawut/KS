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
	$sotype = $_GET["g"];
	$sql = " 
	select 
		so.socode,
		so.sodate,
		concat(e.empname,' ',e.lastname) customer,
		p.productgroupname sotype,
		so.status
	from somaster so
		inner join productgroup p  on p.id = so.sotype 
		inner join employer e on e.empcode = so.empcode 
	where so.sotype = ?
	order by so.socode desc, so.sodate asc;";
	$stmt = mysqli_prepare($conn, $sql); // prepare
	mysqli_stmt_bind_param($stmt, 's', $sotype); // bind array at once
	if (!mysqli_stmt_execute($stmt)) throw new mysqli_sql_exception("get data filed.");
 

	$resultSet = $stmt->get_result();
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
