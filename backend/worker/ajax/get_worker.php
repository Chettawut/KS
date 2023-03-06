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
	$sql = "
	select w.*, em.empcode, em.empname, em.lastname as emp_lastname, em.tel
	from worker w
	left outer join
	(
		select e.empcode, e.wkcode, e.code, e2.empname, e2.lastname, e2.tel
		from employment e 
		inner join employer e2 on e.empcode = e2.empcode
		where e.status  = 'Y' 
		and e.code = 
		(
			select max(s.code)
			from employment s 
			where s.status  = 'Y' and s.wkcode = e.wkcode 
		)
	) em on w.wkcode = em.wkcode
	order by w.wkcode desc;";
	$stmt = $conn->prepare($sql);  
	if (!$stmt->execute()){
		throw new mysqli_sql_exception("Insert data error."); 
	} 

	$resultSet = $stmt->get_result();
	$res = $resultSet->fetch_all(MYSQLI_ASSOC); //MYSQLI_ASSOC

	// Free result set
	$stmt->free_result();

	$conn->close();
	echo json_encode($res);
} catch (mysqli_sql_exception $e) {
	mysqli_close($conn);

	http_response_code(400);
	echo json_encode(array('status' => '0', 'message' => "Sql fail."));
}
exit;
